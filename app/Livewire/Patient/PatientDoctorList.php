<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\View\Components\Layouts\PatientLayout;
use App\Models\DoctorPatients;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use TallStackUi\Traits\Interactions;

#[Layout(PatientLayout::class)]
class PatientDoctorList extends Component
{
    use Interactions;

    public function dialogApproveLink($linkId) {
        $this->dialog()
            ->question('Tem certeza que deseja aceitar este vínculo com o médico?')
            ->confirm(text: "Aceitar", method: "approveLink", params: $linkId)
            ->cancel(text: "Cancelar", method: "cancelled")
            ->send();
    }

    public function dialogUnlinkDoctor($linkId) {
        $this->dialog()
            ->question('Tem certeza que deseja remover este vínculo com o médico?')
            ->confirm(text: "Remover", method: "unlinkDoctor", params: $linkId)
            ->cancel(text: "Cancelar", method: "cancelled")
            ->send();
    }

    public function cancelled() {
        $this->toast()->error('Cancelado')->send();
    }

    public function approveLink($linkId) {
        $doctorPatient = DoctorPatients::find($linkId);
        
        if (!$doctorPatient) {
            $this->toast()->error('Vínculo não encontrado.')->send();
            return;
        }

        $doctorPatient->update([
            'dop_status' => DoctorPatients::STATUS_LINKED
        ]);

        $this->toast()->success('Vínculo aceito com sucesso!')->send();
    }

    public function unlinkDoctor($linkId) {
        $doctorPatient = DoctorPatients::find($linkId);
        
        if (!$doctorPatient) {
            $this->toast()->error('Vínculo não encontrado.')->send();
            return;
        }

        $doctorPatient->delete();

        $this->toast()->success('Vínculo removido com sucesso!')->send();
    }

    public function render()
    {
        $patientId = Auth::user()->usr_represented_agent;

        // Get all doctor-patient relationships for this patient
        $doctorPatients = DoctorPatients::where('patient_pat_id', $patientId)
            ->with(['doctor'])
            ->get();

        // Process to get doctor information
        $doctorsList = [];
        
        foreach ($doctorPatients as $doctorPatient) {
            // Find the User associated with this doctor
            $doctorUser = User::where('usr_role', User::ROLE_DOCTOR)
                ->where('usr_represented_agent', $doctorPatient->doctor_doc_id)
                ->first();

            if ($doctorUser) {
                $doctorsList[] = [
                    'link_id' => $doctorPatient->dop_id,
                    'doctor_id' => $doctorPatient->doctor_doc_id,
                    'name' => $doctorUser->usr_name,
                    'email' => $doctorUser->usr_email,
                    'crm' => $doctorPatient->doctor->doc_crm ?? 'N/A',
                    'status' => $doctorPatient->dop_status,
                ];
            }
        }

        return view('livewire.patient.patient-doctor-list', [
            'doctorsList' => $doctorsList,
        ]);
    }
}
