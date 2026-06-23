<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Other IT Service Request</title>
    <style>
        @page {
            margin: 18px 20px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #111827;
            margin: 0;
        }

        .copy {
            border: 1px solid #222;
            padding: 10px 12px;
            margin-bottom: 18px;
        }

        .copy:last-child {
            margin-bottom: 0;
        }

        .top-line {
            width: 100%;
            margin-bottom: 6px;
            font-size: 10px;
        }

        .top-line td:first-child {
            text-align: left;
        }

        .top-line td:last-child {
            text-align: right;
        }

        .header {
            text-align: center;
            margin-bottom: 8px;
        }

        .header .small {
            font-size: 10px;
        }

        .header .title {
            font-size: 22px;
            font-weight: bold;
            color: #1d4ed8;
            margin-top: 4px;
            text-transform: uppercase;
        }

        .section {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .section td,
        .section th {
            vertical-align: top;
            padding: 3px 4px;
        }

        .label {
            width: 130px;
            font-weight: bold;
            white-space: nowrap;
        }

        .line {
            border-bottom: 1px solid #333;
            min-height: 15px;
            display: block;
            width: 100%;
            padding: 0 2px 2px;
        }

        .box {
            border: 1px solid #333;
            width: 10px;
            height: 10px;
            display: inline-block;
            text-align: center;
            line-height: 9px;
            font-size: 9px;
            margin-right: 4px;
        }

        .checked {
            font-weight: bold;
        }

        .service-grid {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2px;
        }

        .service-grid td {
            padding: 3px 4px;
            vertical-align: middle;
        }

        .subsection-title {
            font-weight: bold;
            border-top: 1px dashed #333;
            border-bottom: 1px dashed #333;
            padding: 4px 0;
            margin: 10px 0 6px;
        }

        .feedback-title {
            text-align: center;
            font-weight: bold;
            margin-top: 8px;
            margin-bottom: 2px;
        }

        .feedback-subtitle {
            text-align: center;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .rating-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .rating-table th,
        .rating-table td {
            border: 1px solid #333;
            padding: 4px;
            text-align: center;
            vertical-align: top;
            font-size: 10px;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .signature-table td {
            border: 1px solid #333;
            padding: 6px 8px;
            height: 28px;
        }

        .muted {
            color: #4b5563;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    @php
        $checked = fn ($value) => $value ? '✓' : '';
        $dateOfRequest = $requestRecord->date_of_request
            ? \Illuminate\Support\Carbon::parse($requestRecord->date_of_request)->format('F d, Y')
            : '';
        $activityDateTime = $requestRecord->activity_datetime
            ? \Illuminate\Support\Carbon::parse($requestRecord->activity_datetime)->format('F d, Y h:i A')
            : '';
        $dateReceived = $requestRecord->date_received
            ? \Illuminate\Support\Carbon::parse($requestRecord->date_received)->format('F d, Y')
            : '';
        $feedbackDate = $requestRecord->feedback_date
            ? \Illuminate\Support\Carbon::parse($requestRecord->feedback_date)->format('F d, Y')
            : '';
    @endphp

    {{-- TOP COPY --}}
    <div class="copy">
        <table class="top-line">
            <tr>
                <td>PLGU-BENGUET|ICT-09-V2|2025</td>
                <td>PGO-IT/MIS FILE</td>
            </tr>
        </table>

        <div class="header">
            <div class="small">Republic of the Philippines</div>
            <div><strong>PROVINCE OF BENGUET</strong></div>
            <div>La Trinidad</div>
            <div>Provincial Governor's Office</div>
            <div>Information Technology/Management Information Systems Unit</div>
            <div class="title">Request for Other IT Services</div>
        </div>

        <table class="section">
            <tr>
                <td class="label">Date of request:</td>
                <td><span class="line">{{ $dateOfRequest }}</span></td>
                <td class="label">Control No.:</td>
                <td><span class="line">{{ $requestRecord->control_number }}</span></td>
            </tr>
            <tr>
                <td class="label">Department/Office:</td>
                <td><span class="line">{{ $requestRecord->department_office }}</span></td>
                <td class="label">Signature:</td>
                <td><span class="line"></span></td>
            </tr>
            <tr>
                <td class="label">Name of requestor:</td>
                <td colspan="3"><span class="line">{{ $requestRecord->requestor_name }}</span></td>
            </tr>
        </table>

        <table class="service-grid">
            <tr>
                <td class="label">Service Requested:</td>
                <td><span class="box">{{ $checked($requestRecord->service_printing) }}</span> Printing Services</td>
                <td><span class="box">{{ $checked($requestRecord->service_information_material) }}</span> Information Material</td>
                <td><span class="box">{{ $checked($requestRecord->service_program_paper) }}</span> Program Paper</td>
                <td><span class="box">{{ $checked($requestRecord->service_brochure) }}</span> Brochure</td>
            </tr>
            <tr>
                <td></td>
                <td><span class="box">{{ $checked($requestRecord->service_iec_material) }}</span> IEC Material</td>
                <td><span class="box">{{ $checked($requestRecord->service_handbook) }}</span> Handbook</td>
                <td><span class="box">{{ $checked($requestRecord->service_certificates) }}</span> Certificates</td>
                <td>
                    <span class="box">{{ $checked($requestRecord->service_others) }}</span> Others
                    &nbsp;&nbsp;Qty: <span class="line" style="display:inline-block; width:70px;">{{ $requestRecord->service_qty }}</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4">
                    <span class="box">{{ $checked($requestRecord->service_laptop_tv_setup) }}</span>
                    Set-up of laptop/TV for Meetings/Activities
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4">
                    Others (Please Specify):
                    <span class="line">{{ $requestRecord->service_others_specify }}</span>
                </td>
            </tr>
        </table>

        <table class="section">
            <tr>
                <td class="label">Program/Activity details:</td>
                <td><span class="line">{{ $requestRecord->program_activity_details }}</span></td>
            </tr>
            <tr>
                <td class="label">Date and Time of Activity:</td>
                <td><span class="line">{{ $activityDateTime }}</span></td>
            </tr>
        </table>

        <div class="subsection-title"></div>

        <table class="section">
            <tr>
                <td class="label">For IT/MIS Office use:</td>
                <td class="label">Assigned Personnel:</td>
                <td><span class="line">{{ $requestRecord->assigned_personnel }}</span></td>
            </tr>
            <tr>
                <td></td>
                <td class="label">Date Received:</td>
                <td><span class="line">{{ $dateReceived }}</span></td>
            </tr>
            <tr>
                <td></td>
                <td class="label">Action Taken:</td>
                <td><span class="line">{{ $requestRecord->action_taken }}</span></td>
            </tr>
        </table>

        <div class="subsection-title"></div>

        <div class="feedback-title">REQUESTOR'S FEEDBACK</div>
        <div class="feedback-subtitle">RATING SCALE</div>

        <table class="rating-table">
            <tr>
                <th>5<br>Very Satisfied</th>
                <th>4<br>Satisfied</th>
                <th>3<br>Neutral</th>
                <th>2<br>Dissatisfied</th>
                <th>1<br>Very Dissatisfied</th>
            </tr>
            <tr>
                <td>The service exceeded expectations and was outstanding.</td>
                <td>The service met expectations and was generally positive.</td>
                <td>The service was acceptable, but nothing stood out.</td>
                <td>Some effort was made, but the experience was poor.</td>
                <td>The service did not meet expectations at all.</td>
            </tr>
            <tr>
                <td colspan="5">
                    Selected Rating:
                    <strong>{{ $requestRecord->feedback_rating ?: '-' }}</strong>
                </td>
            </tr>
        </table>

        <table class="signature-table">
            <tr>
                <td><strong>Name:</strong> {{ $requestRecord->feedback_name }}</td>
                <td><strong>Signature:</strong></td>
                <td><strong>Date:</strong> {{ $feedbackDate }}</td>
            </tr>
        </table>
    </div>
    {{-- <div class="page-break"></div> --}}
    {{-- BOTTOM COPY --}}
    <div class="copy">
        <table class="top-line">
            <tr>
                <td>PLGU-BENGUET|ICT-09-V3|2026</td>
                <td>CLIENT FILE</td>
            </tr>
        </table>

        <div class="header">
            <div class="small">Republic of the Philippines</div>
            <div><strong>PROVINCE OF BENGUET</strong></div>
            <div>La Trinidad</div>
            <div>Provincial Governor's Office</div>
            <div>Information Technology/Management Information Systems Unit</div>
            <div class="title">Request for Other IT Services</div>
        </div>

        <table class="section">
            <tr>
                <td class="label">Date of request:</td>
                <td><span class="line">{{ $dateOfRequest }}</span></td>
                <td class="label">Control No.:</td>
                <td><span class="line">{{ $requestRecord->control_number }}</span></td>
            </tr>
            <tr>
                <td class="label">Department/Office:</td>
                <td><span class="line">{{ $requestRecord->department_office }}</span></td>
                <td class="label">Signature:</td>
                <td><span class="line"></span></td>
            </tr>
            <tr>
                <td class="label">Name of requestor:</td>
                <td colspan="3"><span class="line">{{ $requestRecord->requestor_name }}</span></td>
            </tr>
        </table>

        <table class="service-grid">
            <tr>
                <td class="label">Service Requested:</td>
                <td><span class="box">{{ $checked($requestRecord->service_printing) }}</span> Printing Services</td>
                <td><span class="box">{{ $checked($requestRecord->service_information_material) }}</span> Information Material</td>
                <td><span class="box">{{ $checked($requestRecord->service_program_paper) }}</span> Program Paper</td>
                <td><span class="box">{{ $checked($requestRecord->service_brochure) }}</span> Brochure</td>
            </tr>
            <tr>
                <td></td>
                <td><span class="box">{{ $checked($requestRecord->service_iec_material) }}</span> IEC Material</td>
                <td><span class="box">{{ $checked($requestRecord->service_handbook) }}</span> Handbook</td>
                <td><span class="box">{{ $checked($requestRecord->service_certificates) }}</span> Certificates</td>
                <td>
                    <span class="box">{{ $checked($requestRecord->service_others) }}</span> Others
                    &nbsp;&nbsp;Qty: <span class="line" style="display:inline-block; width:70px;">{{ $requestRecord->service_qty }}</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4">
                    <span class="box">{{ $checked($requestRecord->service_laptop_tv_setup) }}</span>
                    Set-up of laptop/TV for Meetings/Activities
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4">
                    Others (Please Specify):
                    <span class="line">{{ $requestRecord->service_others_specify }}</span>
                </td>
            </tr>
        </table>

        <table class="section">
            <tr>
                <td class="label">Program/Activity details:</td>
                <td><span class="line">{{ $requestRecord->program_activity_details }}</span></td>
            </tr>
            <tr>
                <td class="label">Date and Time of Activity:</td>
                <td><span class="line">{{ $activityDateTime }}</span></td>
            </tr>
        </table>

        <div class="subsection-title"></div>

        <table class="section">
            <tr>
                <td class="label">For IT/MIS Office use:</td>
                <td class="label">Assigned Personnel:</td>
                <td><span class="line">{{ $requestRecord->assigned_personnel }}</span></td>
            </tr>
            <tr>
                <td></td>
                <td class="label">Date Received:</td>
                <td><span class="line">{{ $dateReceived }}</span></td>
            </tr>
            <tr>
                <td></td>
                <td class="label">Action Taken:</td>
                <td><span class="line">{{ $requestRecord->action_taken }}</span></td>
            </tr>
        </table>

        <div class="subsection-title"></div>

        <div class="feedback-title">REQUESTOR'S ACCEPTANCE:</div>

        <table class="signature-table">
            <tr>
                <td><strong>Name:</strong> {{ $requestRecord->requestor_name }}</td>
                <td><strong>Signature:</strong></td>
                <td><strong>Date:</strong> {{ $dateOfRequest }}</td>
            </tr>
        </table>
    </div>
</body>
</html>