    <!-- Message Container -->
    <div id="message-container" class="message-container">
        <div id="message-content" class="message-content">
            <!-- Success/Error/Warning/Info messages will be inserted here dynamically -->
            @foreach (['success', 'error', 'warning', 'info'] as $msg)
            @if(session($msg))
            <div>
                {{ session($msg) }}
            </div>
            <script>
                const messageContainer = document.getElementById('message-container');
                messageContainer.classList.add('show', '{{ $msg }}');
            </script>
            @endif
            @endforeach
        </div>
    </div>