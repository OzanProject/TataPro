<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Disposisi - {{ $incoming->agenda_number }}</title>
    <style>
        /* CSS RESET & PRINT SETTINGS */
        @page { size: A4; margin: 1cm; }
        body { font-family: 'Times New Roman', serif; font-size: 12pt; color: #000; line-height: 1.4; margin: 0; }
        
        .container { width: 100%; border: 2px solid #000; padding: 0; box-sizing: border-box; }
        
        /* KOP SURAT */
        .kop-surat { 
            display: flex; 
            align-items: center; 
            padding: 15px; 
            border-bottom: 4px double #000; 
            text-align: center;
        }
        .logo-sekolah { width: 80px; height: auto; position: absolute; left: 30px; }
        .kop-header { width: 100%; }
        .kop-header h1 { margin: 0; font-size: 16pt; text-transform: uppercase; letter-spacing: 1px; }
        .kop-header h2 { margin: 0; font-size: 14pt; text-transform: uppercase; }
        .kop-header p { margin: 2px 0; font-size: 10pt; font-style: italic; }

        /* JUDUL FORM */
        .title-form { 
            text-align: center; 
            background: #eee; 
            padding: 5px 0; 
            border-bottom: 2px solid #000; 
            font-weight: bold; 
            text-transform: uppercase;
        }

        /* TABEL INFORMASI */
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px 12px; vertical-align: top; text-align: left; }
        
        .label { font-weight: bold; font-size: 10pt; text-transform: uppercase; color: #333; display: block; margin-bottom: 4px; }
        .value { font-size: 11pt; font-weight: bold; }

        /* AREA DISPOSISI */
        .disposition-area { padding: 0; }
        .disposition-header { background: #f2f2f2; font-weight: bold; text-align: center; }
        
        /* FOOTER / TANDA TANGAN */
        .footer { margin-top: 20px; padding: 20px; display: flex; justify-content: space-between; align-items: flex-end; }
        .qr-code { width: 100px; text-align: center; font-size: 8pt; color: #666; }
        .signature { text-align: center; width: 250px; }
        
        /* UTILITAS */
        .text-center { text-align: center; }
        .italic { font-style: italic; }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="kop-surat">
            {{-- <img src="{{ asset('img/logo-sekolah.png') }}" class="logo-sekolah"> --}}
            <div class="kop-header">
                <h1>Pemerintah Provinsi Jakarta</h1>
                <h2>SMK NEGERI CONTOH JAKARTA</h2>
                <p>Jl. Pendidikan No. 1, Jakarta Selatan. Telp: (021) 1234567 | Website: www.smkncontoh.sch.id</p>
            </div>
        </div>

        <div class="title-form">Lembar Disposisi</div>

        <table>
            <tr>
                <td width="50%">
                    <span class="label">Surat Dari / Pengirim:</span>
                    <div class="value">{{ $incoming->sender_origin }}</div>
                </td>
                <td width="50%">
                    <span class="label">Tanggal Diterima:</span>
                    <div class="value">{{ $incoming->received_date->format('d F Y') }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label">Nomor Surat Asli:</span>
                    <div class="value">{{ $incoming->mail_number }}</div>
                </td>
                <td>
                    <span class="label">Nomor Agenda (Indeks):</span>
                    <div class="value text-primary" style="font-size: 14pt;">#{{ str_pad($incoming->agenda_number, 4, '0', STR_PAD_LEFT) }}</div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="label">Perihal:</span>
                    <div class="value italic">"{{ $incoming->subject }}"</div>
                </td>
            </tr>
        </table>

        <div class="disposition-area">
            <table>
                <tr class="disposition-header">
                    <td width="35%">Diteruskan Kepada</td>
                    <td>Instruksi / Catatan Pimpinan</td>
                </tr>
                @forelse($incoming->dispositions as $disp)
                <tr>
                    <td>
                        <strong>{{ $disp->receiver->name }}</strong><br>
                        <small class="italic">Tenggat: {{ $disp->due_date->format('d/m/Y') }}</small>
                    </td>
                    <td>
                        <div style="font-weight: bold; margin-bottom: 5px;">{{ $disp->instruction }}</div>
                        @if($disp->note)
                            <div class="small" style="border-top: 1px dashed #ccc; padding-top: 3px;">
                                <span class="label" style="font-size: 8pt;">Catatan Tambahan:</span>
                                {{ $disp->note }}
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr style="height: 250px;">
                    <td><span class="label">Tujuan Manual:</span></td>
                    <td><span class="label">Instruksi Manual:</span></td>
                </tr>
                @endforelse
            </table>
        </div>

        <div class="footer">
            <div class="qr-code">
                {{-- Logika QR Code jika ada library: {!! QrCode::size(80)->generate(url()->current()) !!} --}}
                <div style="border: 1px solid #ccc; width: 80px; height: 80px; margin: 0 auto 5px; display: flex; align-items: center; justify-content: center; font-size: 6pt;">
                    DIGITAL SIGNATURE<br>VALIDATED
                </div>
                ID: {{ strtoupper(substr(md5($incoming->id), 0, 8)) }}
            </div>
            
            <div class="signature">
                <p>Jakarta, {{ date('d F Y') }}</p>
                <p style="margin-bottom: 60px;">Kepala Sekolah,</p>
                <p><strong>Drs. H. Nama Kepala Sekolah, M.Pd</strong></p>
                <p class="small" style="margin-top: -15px;">NIP. 19700101 199501 1 001</p>
            </div>
        </div>
    </div>

    <div style="position: absolute; bottom: 10px; left: 20px; font-size: 8pt; color: #aaa;">
        Dicetak otomatis melalui Sistem TataPro v1.0 pada {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>