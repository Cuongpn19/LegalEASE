@if (session('success') || session('error') || session('warning') || session('info'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100">

        @php
            $types = [
                'success' => ['bg' => 'text-bg-success', 'icon' => 'fa-circle-check'],
                'error' => ['bg' => 'text-bg-danger', 'icon' => 'fa-circle-xmark'],
                'warning' => ['bg' => 'text-bg-warning', 'icon' => 'fa-triangle-exclamation'],
                'info' => ['bg' => 'text-bg-info', 'icon' => 'fa-circle-info'],
            ];
        @endphp

        @foreach ($types as $type => $meta)
            @if (session($type))
                <div class="toast responsive-toast {{ $meta['bg'] }}" role="alert" aria-live="assertive"
                    aria-atomic="true" data-bs-delay="4000">

                    <div class="toast-body d-flex align-items-center gap-2">
                        <i class="fa-solid {{ $meta['icon'] }}"></i>
                        <span>{{ session($type) }}</span>
                    </div>
                </div>
            @endif
        @endforeach

    </div>

    <script>
        document.querySelectorAll('.toast').forEach(toastEl => {
            new bootstrap.Toast(toastEl).show();
        });
    </script>
@endif
