<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Company;
use App\Models\AdminSetting;
use App\Models\CompanyContact;
use App\Models\CompanyAddress;

use Exception;

class AdminCompanyService {
  public function listAllCompanies(): Collection {
    return Company::get();
  }

  public function listAllCompaniesExcept(Int $id): Collection {
    return Company::whereNot('id', $id)->get();
  }

  public function listAllCompaniesWithPagination(Array $filters = []): LengthAwarePaginator {
    $settings = AdminSetting::where('key', 'recordPerPage')->first();
    $recordPerPage = $settings->value ?? 10;

    return Company::with('companyGroup.profile')
    ->where(function ($query) use ($filters) {
      if(isset($filters['id']))
        return $query->where('id', $filters['id']);
    })
    ->whereHas('companyGroup.profile', function ($query) use ($filters) {
      if(isset($filters['profile_id']))
        return $query->where('id', $filters['profile_id']);
    })
    ->paginate($recordPerPage);
  }

  public function getCompanyById(Int $id): Company {
    return Company::with('companyContacts', 'companyAddresses.county')->findOrFail($id);
  }

  public function createAdminCompany(Array $dto) {
    try {
      DB::beginTransaction();
        $dto['active'] = isset($dto['active']) ? true : false;
        $dto['headquarter_id'] = $dto['company_type'] == 'filial' ? $dto['headquarter_id'] : null;

        $company = Company::create($dto);

        $contacts = json_decode($dto['arrContact']);
        foreach($contacts as $contact) {
          if($contact->insert == 'S') {
            $dtoContact = [
              'company_id' => $company->id,
              'type' => $contact->type,
              'value' => $contact->value,
              'active' => $contact->active,
              'main' => $contact->main
            ];

            if(isset($contact->id)) {
              $companyContact = CompanyContact::findOrFail($contact->id);
              $companyContact->update($dtoContact);
            } else {
              CompanyContact::create($dtoContact);
            }
          }
        }

        $addresses = json_decode($dto['arrAddress']);
        foreach($addresses as $address) {
          $dtoAddress = [
            'company_id' => $company->id,
            'county_id' => $address->countyId,
            'active' => $address->active,
            'main' => $address->main,
            'zip_code' => $address->zipCode,
            'address' => $address->address,
            'number' => $address->number,
            'neighborhood' => $address->neighborhood,
            'complement' => $address->complement,
          ];

          if($address->insert == 'S') {
            if(isset($address->id)) {
              $companyAddress = CompanyAddress::findOrFail($address->id);
              $companyAddress->update($dtoAddress);
            } else {
              CompanyAddress::create($dtoAddress);
            }
          } else {
            $companyAddress = CompanyAddress::findOrFail($address->id);
            $companyAddress->delete();
          }
        }
      DB::commit();

      return true;
    } catch (Exception $e) {
      DB::rollBack();
      return throw new Exception($e->getMessage());
    }
  }

  public function updateAdminCompany(Int $id, Array $dto) {
    try {
      DB::beginTransaction();
        $dto['active'] = isset($dto['active']) ? true : false;
        $dto['headquarter_id'] = $dto['company_type'] == 'filial' ? $dto['headquarter_id'] : null;

        $company = Company::findOrFail($id);
        $company->update($dto);

        $contacts = json_decode($dto['arrContact']);
        foreach($contacts as $contact) {
          $dtoContact = [
            'company_id' => $company->id,
            'type' => $contact->type,
            'value' => $contact->value,
            'active' => $contact->active,
            'main' => $contact->main
          ];

          if($contact->insert == 'S') {
            if(isset($contact->id)) {
              $companyContact = CompanyContact::findOrFail($contact->id);
              $companyContact->update($dtoContact);
            } else {
              CompanyContact::create($dtoContact);
            }
          } else {
            $companyContact = CompanyContact::findOrFail($contact->id);
            $companyContact->delete();
          }
        }

        $addresses = json_decode($dto['arrAddress']);
        foreach($addresses as $address) {
          $dtoAddress = [
            'company_id' => $company->id,
            'county_id' => $address->countyId,
            'active' => $address->active,
            'main' => $address->main,
            'zip_code' => $address->zipCode,
            'address' => $address->address,
            'number' => $address->number,
            'neighborhood' => $address->neighborhood,
            'complement' => $address->complement,
          ];

          if($address->insert == 'S') {
            if(isset($address->id)) {
              $companyAddress = CompanyAddress::findOrFail($address->id);
              $companyAddress->update($dtoAddress);
            } else {
              CompanyAddress::create($dtoAddress);
            }
          } else {
            $companyAddress = CompanyAddress::findOrFail($address->id);
            $companyAddress->delete();
          }
        }
      DB::commit();

      return true;
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
      return throw new Exception($e->getMessage());
    }
  }
}
