<div style="position: inherit;">
    <strong style="font-size: 16px; font-weight: 600; color: #597a96; display: inherit;">
        {{ isset($announcement->starts_at) ? $announcement->starts_at->toDateString() : '-' }}
    </strong>
    <span style="font-size: 12px; font-weight: 400; color: #aab8c2;">
        {{ isset($announcement->starts_at) ? $announcement->starts_at->toTimeString() : '' }}
    </span>
</div>
