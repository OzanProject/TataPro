<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Induk Siswa</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }

        .container {
            width: 100%;
            max-width: 210mm;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            position: relative;
        }

        .header h2 {
            margin: 0;
            font-size: 18pt;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .header h3 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
            font-weight: bold;
        }

        .title {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td {
            vertical-align: top;
            padding: 5px 0;
        }

        .label {
            width: 40%;
            font-weight: bold;
        }

        .sep {
            width: 2%;
        }

        .val {
            width: 58%;
        }

        .photo-box {
            width: 3cm;
            height: 4cm;
            border: 1px solid #000;
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10pt;
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .signature {
            float: right;
            margin-top: 50px;
            text-align: center;
            width: 40%;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }

            .no-print {
                display: none;
            }

            .page-break {
                page-break-after: always;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="no-print" style="position: fixed; top: 20px; right: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-weight: bold; cursor: pointer;">CETAK
            SEMUA</button>
    </div>

    @foreach($students as $student)
        <div class="container page-break">

            <div class="header">
                @if(isset($settings['school_logo']))
                    <img src="{{ asset('storage/' . $settings['school_logo']) }}"
                        style="width: 80px; position: absolute; left: 0; top: 0;">
                @endif
                <h3>{{ strtoupper($settings['school_name'] ?? 'SEKOLAH TATA USAHA PRO') }}</h3>
                <h2>LEMBAR BUKU INDUK SISWA</h2>
            </div>

            <div class="title">DATA PRIBADI SISWA</div>

            <table>
                <tr>
                    <td class="label">1. Nama Lengkap</td>
                    <td class="sep">:</td>
                    <td class="val"><b>{{ strtoupper($student->name) }}</b></td>
                </tr>
                <tr>
                    <td class="label">2. Nomor Induk Siswa (NIS)</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $student->nis }}</td>
                </tr>
                <tr>
                    <td class="label">3. NISN</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $student->nisn ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">4. Tempat, Tanggal Lahir</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $student->place_of_birth ?? '...' }},
                        {{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->translatedFormat('d F Y') : '...' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">5. Jenis Kelamin</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                </tr>
                <tr>
                    <td class="label">6. Agama</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $student->religion ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">7. Alamat Peserta Didik</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $student->address ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">8. No. Telepon / HP</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $student->phone ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td class="label">9. Nama Ayah Kandung</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $student->father_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">10. Pekerjaan Ayah</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $student->father_job ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">11. Nama Ibu Kandung</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $student->mother_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">12. Pekerjaan Ibu</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $student->mother_job ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">13. Alamat Orang Tua</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $student->parent_address ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">14. No. Telepon / HP Orang Tua</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $student->parent_phone ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td class="label">15. Diterima di sekolah ini</td>
                    <td class="sep"></td>
                    <td class="val"></td>
                </tr>
                <tr>
                    <td class="label" style="padding-left: 20px;">a. Di Kelas</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $student->accepted_grade ?? '...' }}</td>
                </tr>
                <tr>
                    <td class="label" style="padding-left: 20px;">b. Pada Tanggal</td>
                    <td class="sep">:</td>
                    <td class="val">
                        {{ $student->accepted_date ? \Carbon\Carbon::parse($student->accepted_date)->translatedFormat('d F Y') : '...' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">16. Sekolah Asal</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $student->previous_school ?? '-' }}</td>
                </tr>
            </table>

            <div style="margin-top: 50px; overflow: hidden;">
                <div style="float: left; margin-left: 20px;">
                    <div class="photo-box">
                        FOTO<br>3x4
                    </div>
                </div>

                <div class="signature">
                    <p>{{ $settings['school_city'] ?? 'Kota' }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p>Kepala Sekolah,</p>
                    <div style="height: 2.5cm;"></div>
                    <p><b>( {{ strtoupper($settings['principal_name'] ?? '.........................................') }}
                            )</b><br>
                        NIP. {{ $settings['principal_nip'] ?? '............................' }}</p>
                </div>
            </div>

        </div>
    @endforeach

</body>

</html>