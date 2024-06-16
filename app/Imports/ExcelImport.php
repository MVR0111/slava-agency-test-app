<?php

namespace App\Imports;

use App\Events\RowsCreated;
use App\Models\Row;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class ExcelImport implements ToCollection
{
    protected array $errors = [];
    protected int $processedRows = 0;
    protected int $jobId;

    public function __construct(int $jobId)
    {
        $this->jobId = $jobId;
    }

    public function collection(Collection $collection): void
    {
        $collection->shift();
        $chunks = $collection->chunk(1000);

        foreach ($chunks as $chunk) {
            foreach ($chunk as $row) {
                $rowNumber = $this->processedRows + 2;

                $data = [
                    'excel_id' => $row[0],
                    'name' => $row[1],
                    'date' => $row[2],
                ];

                $validator = Validator::make($data, [
                    'excel_id' => 'required|integer|gt:0|unique:rows,excel_id',
                    'name' => 'required|regex:/^[a-zA-Z ]+$/',
                    'date' => 'required|date_format:d.m.Y|before_or_equal:today',
                ]);

                if ($validator->fails()) {
                    $this->errors[] = "$rowNumber - " . implode(', ', $validator->errors()->all());
                    $this->processedRows++;
                    continue;
                }

                try {
                    $data['date'] = Carbon::createFromFormat('d.m.Y', $data['date'])->format('Y-m-d');
                    $rowsToInsert[] = $data;
                } catch (\Exception $e) {
                    $this->errors[] = "$rowNumber - " . $e->getMessage();
                }

                $this->processedRows++;
            }

            if (!empty($rowsToInsert)) {
                Row::insert($rowsToInsert);
                RowsCreated::dispatch(count($rowsToInsert));
                $rowsToInsert = [];
            }

            Redis::set('processing:progress:' . $this->jobId , $this->processedRows);
        }

        if (!empty($this->errors)) {
            Storage::put('result.txt', implode(PHP_EOL, $this->errors));
        }
    }
}
