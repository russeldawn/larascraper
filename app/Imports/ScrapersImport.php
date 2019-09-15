<?php

namespace App\Imports;

use App\Models\Scraper;
// use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class ScrapersImport implements ToCollection
{
    use Importable;

    // /**
    // * @param array $row
    // *
    // * @return \Illuminate\Database\Eloquent\Model|null
    // */
    // public function model(array $row)
    // {
    //     dd($row[0]);
    //     // return new Scraper([
    //     //     //
    //     // ]);
    // }
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $parsed_row = \str_replace('-', '', $row[0]);

            // initialize variables
            $client = new Client();
            $result = null;
            $data = null;

            // intialize https request
            $request = new Request('GET', 'https://www8.miamidade.gov/Apps/PA/PApublicServiceProxy/PaServicesProxy.ashx?Operation=GetPropertySearchByFolio&clientAppName=PropertySearch&folioNumber=' . $parsed_row );

            // send https request
            $promise = $client->sendAsync($request)->then(function ($response) {
                // if ($response->getStatusCode() === 200) {
                    return [
                        'status' => $response->getStatusCode(),
                        'body' => (string)$response->getBody()
                    ];
                // }
            });

            $result = $promise->wait();

            // check if promise status is sucess
            if ($result['status'] === 200) {

                $data = json_decode($result['body']);
                $owner = [];
                $mail_address = [];
                $assessmentInfos = [];
                $sales_info = [];
                $siteAddress = null;

                // dd($data->SiteAddress);

                // iterate over site address property in object data
                foreach ($data->SiteAddress as $site) {
                    $siteAddress = $site->Address;
                }

                // iterate over owner info property in object data
                foreach ($data->OwnerInfos as $ownerInfo) {
                    // dd($ownerInfo->Name);
                    array_push($owner, $ownerInfo->Name);
                }

                // iterate over mailing address property in object data
                foreach ($data->MailingAddress as $key => $value) {
                    if (!empty($value)) {
                        array_push($mail_address, $value);
                    }
                }

                // iterate over assessment information property in object data
                foreach ($data->Assessment->AssessmentInfos as $assessInfos) {
                    foreach ($assessInfos as $key => $value) {
                        array_push($assessmentInfos, $key . ' : ' . $value);
                    }
                }

                // iterate over mailing address property in object data
                foreach ($data->SalesInfos as $saleInfo) {
                    array_push($sales_info, $saleInfo->DateOfSale . ' : ' . $saleInfo->SalePrice);
                }

                // dd($data->PropertyInfo->FolioNumber);
                $folio = $data->PropertyInfo->FolioNumber ? $data->PropertyInfo->FolioNumber : '';
                $siteAddress = $siteAddress ? $siteAddress : '';
                $owner = implode(', ', $owner);
                $mail_address = count($mail_address) > 0 ? implode(', ', $mail_address) : '';
                $primary_zone = !empty($data->PropertyInfo->PrimaryZone) ? $data->PropertyInfo->PrimaryZone : '';
                $primary_zone .= !empty($data->PropertyInfo->PrimaryZoneDescription) ? $data->PropertyInfo->PrimaryZoneDescription : '';
                $primary_land_use = !empty($data->PropertyInfo->DORCode) ? $data->PropertyInfo->DORCode : '';
                $primary_land_use .= !empty($data->PropertyInfo->DORDescription) ? $data->PropertyInfo->DORDescription : '';
                $primary_land_use .= !empty($data->PropertyInfo->DORDescriptionCurrent) ? $data->PropertyInfo->DORDescriptionCurrent : '';
                $bed_bath_half = [ $data->PropertyInfo->BathroomCount, $data->PropertyInfo->BedroomCount, $data->PropertyInfo->HalfBathroomCount ];
                $bed_bath_half = implode(' / ', $bed_bath_half);
                $living_area = $data->PropertyInfo->BuildingActualArea;
                $year_built = $data->PropertyInfo->YearBuilt;
                $assessmentInfos = implode(', ', $assessmentInfos);
                $full_legal_desc = $data->LegalDescription->Description;
                $sales_info = implode(', ', $sales_info);

                Scraper::create([
                    'pi_folio'              => $folio,
                    'pi_property_address'   => $siteAddress,
                    'pi_owner'              => $owner,
                    'pi_mail_address'       => $mail_address,
                    'pi_primary_zone'       => $primary_zone,
                    'pi_primary_land_use'   => $primary_land_use,
                    'pi_bed_bath_half'      => $bed_bath_half,
                    'pi_living_area'        => $living_area,
                    'pi_year_built'         => $year_built,
                    'assessment_info'       => $assessmentInfos,
                    'full_legal_description' => $full_legal_desc,
                    'sales_info'            => $sales_info
                ]);
            } else {
                dd('You got Disconnected! Your last Folio Number was' . $parsed_row);
            }


        }
    }
}
