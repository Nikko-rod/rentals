<div id="toast" class="toast {{ session('success') ? 'show success' : '' }} {{ session('error') ? 'show error' : '' }}">
    <div class="toast-content">
        @if(session('success'))
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        @endif
        @if(session('error'))
            <i class="fas fa-times-circle"></i>
            <span>{{ session('error') }}</span>
        @endif
    </div>
</div>