<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            background: #f8fafc;
            color: #1e293b;
            padding: 40px;
        }

        .ticket {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            max-width: 600px;
            margin: 0 auto;
        }

        .ticket-header {
            background: #4f46e5;
            padding: 36px 40px;
            color: white;
        }

        .ticket-header .brand {
            font-size: 13px;
            color: #a5b4fc;
            margin-bottom: 8px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .ticket-header h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .ticket-header .location {
            font-size: 13px;
            color: #c7d2fe;
        }

        .ticket-code-section {
            padding: 24px 40px;
            border-bottom: 2px dashed #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .ticket-code-label {
            font-size: 11px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }

        .ticket-code {
            font-family: DejaVu Sans Mono, monospace;
            font-size: 22px;
            font-weight: 700;
            color: #4f46e5;
            letter-spacing: 3px;
        }

        .status-badge {
            background: #d1fae5;
            color: #065f46;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .ticket-details {
            padding: 28px 40px;
        }

        .details-grid {
            width: 100%;
        }

        .detail-row {
            margin-bottom: 18px;
        }

        .detail-row td {
            vertical-align: top;
            width: 50%;
            padding-right: 20px;
        }

        .detail-label {
            font-size: 11px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .detail-value {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }

        .divider {
            border: none;
            border-top: 1px solid #f1f5f9;
            margin: 20px 0;
        }

        .ticket-footer {
            background: #f8fafc;
            padding: 20px 40px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }

        .ticket-footer p {
            font-size: 11px;
            color: #94a3b8;
            line-height: 1.6;
        }

        .ticket-footer .portal-name {
            font-size: 13px;
            font-weight: 700;
            color: #4f46e5;
            margin-bottom: 4px;
        }

        .amount {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
        }

        .free-badge {
            background: #ede9fe;
            color: #5b21b6;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="ticket">

        {{-- Header --}}
        <div class="ticket-header">
            <div class="brand">EventPortal · Official Ticket</div>
            <h1>{{ $ticket->event->title }}</h1>
            <div class="location">📍 {{ $ticket->event->location }}</div>
        </div>

        {{-- Ticket Code --}}
        <div class="ticket-code-section">
            <div>
                <div class="ticket-code-label">Ticket Code</div>
                <div class="ticket-code">{{ $ticket->ticket_code }}</div>
            </div>
            <div class="status-badge"> {{ ucfirst($ticket->status) }}</div>
        </div>

        {{-- Details --}}
        <div class="ticket-details">
            <table class="details-grid">
                <tr class="detail-row">
                    <td>
                        <div class="detail-label">Attendee</div>
                        <div class="detail-value">{{ $ticket->user->name }}</div>
                    </td>
                    <td>
                        <div class="detail-label">Email</div>
                        <div class="detail-value">{{ $ticket->user->email }}</div>
                    </td>
                </tr>
                <tr class="detail-row">
                    <td>
                        <div class="detail-label">Event Date</div>
                        <div class="detail-value">{{ $ticket->event->start_date->format('l, d M Y') }}</div>
                    </td>
                    <td>
                        <div class="detail-label">Time</div>
                        <div class="detail-value">
                            {{ $ticket->event->start_date->format('g:ia') }} –
                            {{ $ticket->event->end_date->format('g:ia') }}
                        </div>
                    </td>
                </tr>
                <tr class="detail-row">
                    <td>
                        <div class="detail-label">Organiser</div>
                        <div class="detail-value">{{ $ticket->event->organiser->name }}</div>
                    </td>
                    <td>
                        <div class="detail-label">Purchased</div>
                        <div class="detail-value">{{ $ticket->purchased_at->format('d M Y, g:ia') }}</div>
                    </td>
                </tr>
                <tr class="detail-row">
                    <td>
                        <div class="detail-label">Amount Paid</div>
                        <div class="detail-value">
                            @if((float) $ticket->amount_paid === 0.0)
                                <span class="free-badge">Free</span>
                            @else
                                <span class="amount">${{ number_format($ticket->amount_paid, 2) }}</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="detail-label">Ticket ID</div>
                        <div class="detail-value">#{{ $ticket->id }}</div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- Footer --}}
        <div class="ticket-footer">
            <div class="portal-name">EventPortal</div>
            <p>
                This is your official ticket. Please present this document at the event entrance.<br>
                Generated on {{ now()->format('d M Y, g:ia') }}
            </p>
        </div>

    </div>
</body>

</html>