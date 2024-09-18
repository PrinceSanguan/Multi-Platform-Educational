<!-- resources/views/chat/index.blade.php -->

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center font-weight-bold">
                    Chat Room
                </div>

                <div class="card-body">
                    <div class="chat-box p-3" style="height: 400px; overflow-y: auto; background-color: #f5f5f5; border-radius: 8px;">
                        <!-- Display messages -->
                        @foreach($thread->messages as $message)
                            <div class="message mb-3 d-flex {{ $message->sender_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                                <div class="{{ $message->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-light text-dark' }} p-3" style="border-radius: 10px; max-width: 70%;">
                                    <strong>{{ $message->sender->name }}</strong> <br>
                                    {{ $message->message }}
                                    <div class="text-muted small mt-2">{{ $message->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Message input -->
                    <form action="{{ url('/chat/' . $thread->id) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="input-group">
                            <textarea name="message" class="form-control" rows="1" placeholder="Type your message..." required></textarea>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and dependencies (Optional, if not already included) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Auto-scroll to the bottom of the chat box -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var chatBox = document.querySelector('.chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    });
</script>