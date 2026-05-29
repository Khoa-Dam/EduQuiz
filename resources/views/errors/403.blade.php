<x-error-page
    code="403"
    title="Access denied"
    message="You do not have permission to access this page."
    cta-label="Back to dashboard"
    :cta-href="auth()->check() ? route('dashboard') : url('/')"
/>
