<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Http\Controllers\dao\GenericCtrl;
use App\Models\Question;
use App\Models\Appointment;
use App\Models\AppointmentAnswer;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.patient-layout')]
class PatientAppointmentForm extends Component
{
    use Interactions;

    public $questions = null;
    public $answers = [];
    public $appointmentId = null;
    public $existingAppointment = null;
    public $isViewMode = false;

    public function mount($id = null) {
        $questionCtrl = new GenericCtrl("Question");
        $this->questions = $questionCtrl->getObjectByField("que_domain", Question::DOMAIN_APPOINTMENT_QUESTIONS, false);
        
        // Initialize answers array
        foreach ($this->questions as $question) {
            $this->answers[$question->que_id] = '';
        }

        // If viewing existing appointment
        if ($id) {
            $this->appointmentId = $id;
            $this->isViewMode = true;
            $this->loadExistingAppointment($id);
        }
    }

    private function loadExistingAppointment($appointmentId) {
        $this->existingAppointment = Appointment::where('app_id', $appointmentId)
            ->with('appointmentAnswers')
            ->first();

        if ($this->existingAppointment && $this->existingAppointment->appointmentAnswers->isNotEmpty()) {
            // Load answers into the answers array
            foreach ($this->existingAppointment->appointmentAnswers as $answer) {
                $this->answers[$answer->question_que_id] = $answer->apa_answer;
            }
        }
    }

    public function updateAnswer($questionId, $value) {
        $this->answers[$questionId] = $value;
    }

    public function submitForm() {
        // Validate that all questions are answered
        foreach ($this->answers as $questionId => $value) {
            if (empty($value)) {
                $this->toast()->error('Por favor, responda todas as perguntas antes de enviar.')->send();
                return null;
            }
        }

        $patientId = Auth::user()->usr_represented_agent;
        $today = date('Y-m-d');

        // Create Appointment
        $appointment = Appointment::create([
            'app_date' => $today,
            'app_diagnosis' => '',
            'patient_pat_id' => $patientId,
            'doctor_doc_id' => null, // Will be set when doctor is assigned
        ]);

        // Create AppointmentAnswers for each question
        foreach ($this->answers as $questionId => $value) {
            AppointmentAnswer::create([
                'apa_answer' => $value,
                'question_que_id' => $questionId,
                'appointment_app_id' => $appointment->app_id,
            ]);
        }

        $this->toast()->success('Consulta registrada com sucesso!')->send();
        return $this->redirect(route('patient.appointment-list'));
    }

    public function goBack() {
        return $this->redirect(route('patient.appointment-list'));
    }

    public function render()
    {
        return view('livewire.patient.patient-appointment-form');
    }
}
