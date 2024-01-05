<?php

namespace App\Exports;

use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ParserExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected string $date;
    public function __construct($date)
    {
        $this->date = $date;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): Collection
    {
        $fileContents = explode(PHP_EOL, Storage::get('public/temp/raw.txt'));
        Storage::delete('public/temp/raw.txt');
        $accounts = [
            '350370-604' => 'Bank of Tokyo;JPY;F',
            '350001-604' => 'Bangladesh Bank Ref-3;JPY;L',
            '350168-611' => 'J.P. Morgan Bank;USD;F',
            '350818-611' => 'American Express Bank;USD;F',
            '353345-611' => 'HSBC USA;USD;F',
            '350117-611' => 'HSBC, U.K.;USD;F',
            '350869-611' => 'Lloyds Bank, U.K.;USD;F',
            '350880-611' => 'Mashreq Bank;USD;F',
            '350443-611' => 'Commertz Bank;USD;F',
            '350338-611' => 'City N.A.;USD;F',
            '350354-611' => 'WELLS FARGO N.A.;USD;F',
            '750007-611' => 'Habib American Bank;USD;F',
            '350001-611' => 'Bangladesh Bank Ref. - 3;USD;L',
            '350281-611' => 'Mayanmer Economic Bank;USD;F',
            '350001-612' => 'Bangladesh Bank Ref-3;UKP;L',
            '350117-612' => 'HSBC;UKP;F',
            '350869-612' => 'Lloyds Bank;UKP;F',
            '350443-615' => 'Commertz Bank;EUR;F',
            '353604-615' => 'Hypo Bank;EUR;F',
            '350001-614' => 'Bangladesh Bank Euro A/C;EUR;L',
            '350729-611' => 'IFIC Karachi;USD;F',
            '350451-611' => 'State Bank of India;USD;F',
            '350362-611' => 'Hattan National Bank;USD;F',
            '350982-611' => 'ABBL Mumbai;USD;F',
            '350265-611' => 'Sonali Bank;USD;L',
            '353582-611' => 'Bank of Bhutan;USD;F',
            '750131-611' => 'HSBC Mumbai;USD;F',
            '750132-611' => 'HSBC Karachi;USD;F',
            '353418-611' => 'NEPAL BD;USD;F',
            '350303-611' => 'BCCI LONDON ú W;USD;F',
            '750097-611' => 'Natnl Comm Bank;USD;F',
            '750119-615' => 'Habib Bank Zuri;AED;F',
            '750118-611' => 'Habib Metro Bnk;USD;F',
            '350982-615' => 'ABBL MUMBAI EUR;EUR;F',
            '750147-617' => 'SCB Singapore;SGD;F',
            '750150-611' => 'COMMERZ BK CAD;CAD;F',
            '750151-616' => 'COMMERZ BK CHF;CHF;F',
            '750152-616' => 'HSBC AUSTRALIA;AUD;F',
            '750154-611' => 'SCB,NY,USA;USD;F',
            '750159-611' => 'HABIB UK;USD;F',
            '350095-613' => 'SONALI BK UK;UKP;L',
            '350095-610' => 'SONALI BK UK;USD;L',
            '750175-615' => 'HABIB AG EUR;EUR;F',
            '750178-617' => 'HSBC HK CHK	CNY;CNY;F',
            '750191-612' => 'SCB,UK,GBP;UKP;F',
            '750160-612' => 'HABIB GBP,UK;UKP;F'
        ];
        $contents = '[';
        foreach ($fileContents as $key => $fileContent) {
            $lineContents = explode(' ', $fileContent);
            foreach ($lineContents as $lineKey => $lineContent) {
                if (array_key_exists($lineContent, $accounts)) {
                    $trxAmount = '';
                    $trxAmountType = '';
                    for ($i = ($lineKey + 1); $i < count($lineContents); $i++) {
                        if ($lineContents[$i] === 'C' || $lineContents[$i] === 'D') {
                            $reference = '';
                            for ($k = ($i + 1); $k < count($lineContents); $k++) {
                                if ($lineContents[$k] !== '' && ! is_numeric($lineContents[$k]) && count(explode(',', $lineContents[$k])) < 2) {
                                    $reference = $reference . ' ' . trim($lineContents[$k]);
                                }
                            }
                            if ($lineContents[$i] === 'C') {
                                $trxAmountType = 'C';
                            }
                            if ($lineContents[$i] === 'D') {
                                $trxAmountType = 'D';
                            }
                            for ($j = ($i - 1); $j > ($lineKey + 1); $j--) {
                                if ($lineContents[$j] !== '') {
                                    if (strpos($lineContents[$j], '.') !== false || strpos($lineContents[$j], ',') !== false) {
                                        $trxAmount = $lineContents[$j];
                                        break;
                                    }
                                }
                            }
                            break;
                        }
                    }
                    if ($trxAmountType == 'C') {
                        $credit = $trxAmount;
                        $debit = 0;
                    } elseif ($trxAmountType == 'D') {
                        $credit = 0;
                        $debit = $trxAmount;
                    }
                    $schedule = $lineContents[0];
                    if ($lineContents[0] === 'FITD') {
                        if ($credit === 0) {
                            if (explode(';', $accounts[$lineContent])[2] === 'F') {
                                $schedule = 'B';
                            }
                            if (explode(';', $accounts[$lineContent])[2] === 'L') {
                                $schedule = 'C';
                            }
                            if (in_array('FFXINT', $lineContents) || in_array('FFXINTT', $lineContents) || in_array('FFXRBT', $lineContents) || in_array('FFXSWIFT', $lineContents) || in_array('FFXCHGS', $lineContents) || in_array('FFXCHG', $lineContents) || in_array('FFXFEES', $lineContents) || in_array('FFXBBK', $lineContents) || in_array('FFXABIFLDIV', $lineContents) || in_array('FFXMUMPFT', $lineContents)) {
                                $schedule = 'IRV';
                            }
                        }
                        if ($debit === 0) {
                            if (explode(';', $accounts[$lineContent])[2] === 'F') {
                                $schedule = 'F';
                            }
                            if (explode(';', $accounts[$lineContent])[2] === 'L') {
                                $schedule = 'G';
                            }
                            if (in_array('FFXINT', $lineContents) || in_array('FFXINTT', $lineContents) || in_array('FFXRBT', $lineContents) || in_array('FFXSWIFT', $lineContents) || in_array('FFXCHGS', $lineContents) || in_array('FFXCHG', $lineContents) || in_array('FFXFEES', $lineContents)) {
                                $schedule = 'E3P3';
                            }
                        }
                        foreach ($lineContents as $k => $v) {
                            if ($credit === 0) {
                                if (substr($v, 0, 6) === 'FFXINT' || substr($v, 0, 6) === 'FFXRBT' || substr($v, 0, 8) === 'FFXSWIFT' || substr($v, 0, 7) === 'FFXCHGS' || substr($v, 0, 7) === 'FFXFEES') {
                                    $schedule = 'IRV';
                                }
                            }
                            if ($debit === 0) {
                                if (substr($v, 0, 6) === 'FFXINT' || substr($v, 0, 6) === 'FFXRBT' || substr($v, 0, 8) === 'FFXSWIFT' || substr($v, 0, 7) === 'FFXCHGS' || substr($v, 0, 7) === 'FFXFEES') {
                                    $schedule = 'E3P3';
                                }
                            }
                            if (substr($v, 0, 3) === 'FTP' || substr($v, 0, 3) === 'EDC' || substr($v, 0, 3) === 'EDF' || substr($v, 0, 3) === 'FTC') {
                                $schedule = 'TFR';
                            }
                            if (substr($v, 0, 6) === 'FITD81') {
                                $schedule = 'KB';
                            }
                            if (substr($v, 0, 7) === 'FFX6931' || substr($v, 0, 8) === 'FFX06931') {
                                $schedule = 'KIBB';
                            }
                            if (substr($v, 0, 6) === 'FFXREB' || substr($v, 0, 7) === 'FFXCARD' || substr($v, 0, 6) === 'FFXMCD' || substr($v, 0, 9) === 'FFXMUMPFT' || substr($v, 0, 11) === 'FFXABIFLDIV') {
                                $schedule = 'IRV';
                            }
                            if (substr($v, 0, 6) === 'FFXFTR') {
                                $schedule = 'TFR';
                            }
                            if (substr($v, 0, 7) === 'FFXSWFT' || substr($v, 0, 7) === 'FFXMICR') {
                                $schedule = 'E3P3';
                            }

                        }

                    }
                    $narrative = '';
                    for ($m = 1;; $m++) {
                        $nextLineContents = explode(' ', $fileContents[$key + $m]);
                        if ($nextLineContents[0] === '') {
                            foreach ($nextLineContents as $nlKey => $nextLineContent) {
                                if ($nextLineContent !== '') {
                                    $narrative = $narrative . ' ' . trim($nextLineContent);
                                }
                            }
                            if (in_array('fbc', $nextLineContents) || in_array('FBC', $nextLineContents) || in_array('IFL', $nextLineContents) || in_array('ifl', $nextLineContents) || in_array('ftr', $nextLineContents) || in_array('edf', $nextLineContents) || in_array('val', $nextLineContents) || strpos($fileContents[$key + $m], 'uttr') !== FALSE || strpos($fileContents[$key + $m], 'agr') !== FALSE || strpos($fileContents[$key + $m], 'ftr') !== FALSE) {
                                $schedule = 'TFR';
                            }
                            if (in_array('acu', $nextLineContents)) {
                                $schedule = 'D';
                            }
                            if ((in_array('pb', $nextLineContents) && in_array('coll', $nextLineContents)) || (in_array('pb', $nextLineContents) && in_array('fd', $nextLineContents))) {
                                $schedule = 'PB';
                            }
                            if (in_array('kb', $nextLineContents) && in_array('fd', $nextLineContents)) {
                                $schedule = 'KB';
                            }
                            if (in_array('kln', $nextLineContents) && in_array('fd', $nextLineContents)) {
                                $schedule = 'KLN';
                            }
                            if (in_array('swift', $nextLineContents)) {
                                $schedule = 'E3P3';
                            }

                        } else {
                            break;
                        }
                    }
                    if ($credit === 0) {
                        $trxAmount = explode('-', $trxAmount)[0] . '-';
                        $debit = explode('-', $debit)[0] . '-';
                    }
                    $contents .= '{"line":"' . ++$key . '","date":"' . $this->date . '","full_account":"' . implode('', explode('-', $lineContent)) . explode(';', $accounts[$lineContent])[1] . '","name_of_bank":"' . explode(';', $accounts[$lineContent])[0] . '","currency":"' . explode(';', $accounts[$lineContent])[1] . '","trx_amount":"' . $trxAmount . '","debit":"' . $debit . '","credit":"' . $credit . '","input_branch":"' . $lineContents[0] . '","schedule":"' . $schedule . '","reference":"' . trim($reference) . '","narrative":"' . trim($narrative) . '"},';
                }
            }
        }
        $contents = substr($contents, 0, -1);
        $contents .= ']';
        $contents = json_decode($contents);
        return collect($contents);
    }

    public function headings(): array
    {
        return [
            'Line',
            'Date',
            'Full Account',
            'Name of Bank',
            'Currency',
            'Transaction Amount',
            'Debit',
            'Credit',
            'Input Branch',
            'Schedule',
            'Reference',
            'External Reference'
        ];
    }
}
