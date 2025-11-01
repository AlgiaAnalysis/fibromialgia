<?php

namespace App\Traits;

use App\Models\PatientReport;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

trait ReportsTrait
{
    /**
     * Get today's daily report for the authenticated patient
     */
    protected function getTodayDailyReport()
    {
        $patientId = Auth::user()->usr_represented_agent;
        $today = date('Y-m-d');
        
        return PatientReport::where('patient_pat_id', $patientId)
            ->where('par_type', PatientReport::TYPE_DAILY)
            ->whereDate('par_period_starts', $today)
            ->first();
    }

    /**
     * Get latest daily reports for the authenticated patient
     */
    protected function getLatestDailyReports($limit = 10)
    {
        $patientId = Auth::user()->usr_represented_agent;
        
        return PatientReport::where('patient_pat_id', $patientId)
            ->where('par_type', PatientReport::TYPE_DAILY)
            ->orderBy('par_period_starts', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get current FIQR report for the authenticated patient
     */
    protected function getCurrentFiqrReport()
    {
        $patientId = Auth::user()->usr_represented_agent;
        
        return PatientReport::where('patient_pat_id', $patientId)
            ->where('par_type', PatientReport::TYPE_FIQR)
            ->with('patientDomainReports.reportAnswers')
            ->orderBy('par_period_starts', 'desc')
            ->first();
    }

    /**
     * Get latest FIQR reports for the authenticated patient
     */
    protected function getLatestFiqrReports($limit = 10)
    {
        $patientId = Auth::user()->usr_represented_agent;
        
        return PatientReport::where('patient_pat_id', $patientId)
            ->where('par_type', PatientReport::TYPE_FIQR)
            ->orderBy('par_period_starts', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get FIQR day statuses for current report
     */
    protected function getFiqrDayStatuses($currentFiqrReport)
    {
        $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $dayStatuses = [];
        
        foreach ($weekDays as $day) {
            $dayStatuses[$day] = false;
        }
        
        if ($currentFiqrReport && $currentFiqrReport->patientDomainReports) {
            foreach ($weekDays as $day) {
                // Check if all 3 domains have answers for this day
                $domainCount = 0;
                foreach ($currentFiqrReport->patientDomainReports as $domainReport) {
                    if ($domainReport->pdr_weekday === $day && $domainReport->reportAnswers && $domainReport->reportAnswers->count() > 0) {
                        $domainCount++;
                    }
                }
                // All 3 domains should have answers
                $dayStatuses[$day] = $domainCount === 3;
            }
        }
        
        return $dayStatuses;
    }

    /**
     * Get today's appointment for the authenticated patient
     */
    protected function getTodayAppointment()
    {
        $patientId = Auth::user()->usr_represented_agent;
        $today = date('Y-m-d');
        
        return Appointment::where('patient_pat_id', $patientId)
            ->whereDate('app_date', $today)
            ->first();
    }

    /**
     * Get latest appointments for the authenticated patient
     */
    protected function getLatestAppointments($limit = 10)
    {
        $patientId = Auth::user()->usr_represented_agent;
        
        return Appointment::where('patient_pat_id', $patientId)
            ->orderBy('app_date', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get all week days array
     */
    protected function getWeekDays()
    {
        return ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    }

    /**
     * Get Portuguese day name
     */
    protected function getDayName($day)
    {
        $dayNames = [
            'Monday' => 'Segunda-feira',
            'Tuesday' => 'Terça-feira',
            'Wednesday' => 'Quarta-feira',
            'Thursday' => 'Quinta-feira',
            'Friday' => 'Sexta-feira',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        ];
        
        return $dayNames[$day] ?? $day;
    }
}

