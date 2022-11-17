<div style="position: inherit;">
    <strong style="font-weight: 600; font-size: 16px; color: #597a96; display: inherit;">
        {{ isset($announcement->ends_at) ? $announcement->ends_at->toDateString() : '-' }}
    </strong>
    <span style="font-size: 12px; font-weight: 400; color: #aab8c2;">
        {{ isset($announcement->ends_at) ? $announcement->ends_at->toTimeString() : '' }}
    </span>
</div>
