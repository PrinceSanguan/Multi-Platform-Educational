<!-- resources/views/chat/index.blade.php -->

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Chat Room
                </div>

                <div class="card-body">
                    <div class="chat-box" style="height: 300px; overflow-y: scroll; background-color: #f9f9f9; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                        <!-- Display messages -->
                        @foreach($thread->messages as $message)
                            <div class="message mb-3 p-2" style="{{ $message->sender_id == auth()->id() ? 'text-align: right;' : 'text-align: left;' }}">
                                <div class="d-inline-block px-3 py-2 {{ $message->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-light text-dark' }}" style="border-radius: 10px;">
                                    <strong>{{ $message->sender->name }}</strong> <br>
                                    {{ $message->message }}
                                    <div class="text-muted small" style="margin-top: 5px;">{{ $message->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Message input -->
                    <form action="{{ url('/chat/' . $thread->id) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="input-group">
                            <textarea name="message" class="form-control" rows="2" placeholder="Type your message..." required></textarea>
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
