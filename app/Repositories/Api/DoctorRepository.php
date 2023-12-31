<?php

namespace App\Repositories\Api;

use App\Models\Doctor;
use App\Repositories\Api\CrudRepository;
use Illuminate\Support\Collection;

class DoctorRepository extends CrudRepository
{
    protected $resourceType = Doctor::class;

    /**
     * Get doctors by city.
     *
     * @param int $cidade_id
     * @return \Illuminate\Support\Collection
     */
    public function getDoctorsByCity($cidade_id): Collection
    {
        return $this->resourceType::where('cidade_id', $cidade_id)->get();
    }

    /**
     * Link patient to doctor.
     *
     * @param array $attributes
     * @return \Illuminate\Support\Collection
     */
    public function linkPatientToDoctor($attributes): Collection
    {
        $doctorId = $attributes['medico_id'];
        $patientId = $attributes['paciente_id'];

        $doctor = $this->resourceType::find($doctorId);

        $doctor->patients()->syncWithoutDetaching($patientId);

        $patient = $doctor->patients()->find($patientId);

        return collect([
            'patient' => $patient,
            'doctor' => $doctor,
        ]);
    }
}
