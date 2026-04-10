<?php

namespace App\Imports;

use App\Classes\Country;
use App\Models\Business;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BusinessesImport implements ToModel, WithValidation, WithHeadingRow, WithChunkReading
{
    public function model(array $row)
    {
        $website = cleanURL($row['website']);
        $domain = cleanDomain($website);

        $businessExists = Business::where('website', $website)
            ->orWhere('domain', $domain)->exists();
        if ($businessExists) {
            throw new Exception(d_trans('The business website :business_website has already been taken', ['business_website' => $row['website']]));
        }

        $websiteName = config('settings.general.site_name');
        $shortDescription = "Rate and review {$row['name']} on {$websiteName}";

        return new Business([
            'name' => $row['name'],
            'website' => $website,
            'domain' => $domain,
            'logo' => $row['logo'] ?? null,
            'email' => $row['email'] ?? null,
            'phone' => $row['phone'] ?? null,
            'short_description' => $row['short_description'] ?? $shortDescription,
            'description' => $row['description'] ?? null,
            'tags' => $row['tags'] ?? null,
            'address_line_1' => $row['address_line_1'] ?? null,
            'address_line_2' => $row['address_line_2'] ?? null,
            'city' => $row['city'] ?? null,
            'state' => $row['state'] ?? null,
            'zip' => $row['zip'] ?? null,
            'country' => $row['country'] ?? null,
        ]);
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'block_patterns', 'max:255'],
            'website' => ['required', 'url', 'block_patterns', 'max:255', 'unique:businesses,website'],
            'email' => ['nullable', 'email', 'indisposable', 'block_patterns', 'max:255'],
            'logo' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'block_patterns', 'min:30', 'max:60'],
            'description' => ['nullable', 'string', 'block_patterns', 'max:1500'],
            'tags' => ['nullable', 'string', 'regex:/^([a-zA-Z0-9]+)(,[a-zA-Z0-9]+)*$/'],
            'address_line_1' => ['nullable', 'string', 'max:255', 'block_patterns'],
            'address_line_2' => ['nullable', 'string', 'max:255', 'block_patterns'],
            'city' => ['nullable', 'string', 'max:150', 'block_patterns'],
            'state' => ['nullable', 'string', 'max:150', 'block_patterns'],
            'country' => ['nullable', 'string', 'in:' . implode(',', array_keys(Country::all()))],
        ];
    }

}
