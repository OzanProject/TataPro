<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Buku Agenda</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2, .header h3 { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>{{ $title }}</h2>
        <h3>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</h3>
    </div>

    <table>
        <thead>
             @if($type == 'incoming')
                <tr>
                    <th width="5%">No.</th>
                    <th width="10%">Tgl Terima</th>
                    <th width="15%">No. Surat</th>
                    <th width="10%">Tgl Surat</th>
                    <th width="20%">Pengirim</th>
                    <th width="30%">Perihal</th>
                    <th width="10%">Ket</th>
                </tr>
            @else
                 <tr>
                    <th width="5%">No.</th>
                    <th width="15%">No. Surat</th>
                    <th width="10%">Tgl Surat</th>
                    <th width="20%">Tujuan</th>
                    <th width="30%">Perihal</th>
                    <th width="10%">Status</th>
                    <th width="10%">Ket</th>
                </tr>
            @endif
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td class="text-center">{{ $item->agenda_number }}</td>
                    @if($type == 'incoming')
                        <td class="text-center">{{ $item->received_date->format('d/m/Y') }}</td>
                        <td>{{ $item->mail_number }}</td>
                        <td class="text-center">{{ $item->mail_date->format('d/m/Y') }}</td>
                        <td>{{ $item->sender_origin }}</td>
                        <td>{{ $item->subject }}</td>
                        <td>{{ $item->category->code }}</td>
                    @else
                        <td>{{ $item->mail_number ?? '(Draft)' }}</td>
                        <td class="text-center">{{ $item->mail_date->format('d/m/Y') }}</td>
                        <td>{{ $item->recipient_destination }}</td>
                        <td>{{ $item->subject }}</td>
                        <td class="text-center">
                            @if($item->status == 'sent') Terkirim 
                            @elseif($item->status == 'draft') Konsep
                            @elseif($item->status == 'pending_approval') Menunggu Persetujuan
                            @elseif($item->status == 'approved') Disetujui
                            @elseif($item->status == 'rejected') Ditolak
                            @else {{ ucfirst(str_replace('_', ' ', $item->status)) }} @endif
                        </td>
                        <td>{{ $item->category->code }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; text-align: right;">
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
