@extends('admin.includes.main')
@push('title')
    <title>Messages - Admin Dashboard - Gifts Hub</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center my-4">
                <h1 class="mb-0">Messages</h1>
                <div class="d-flex gap-2">
                    <form method="POST" action="{{ route('admin.messages.delete.all') }}" onsubmit="return confirm('Are you sure you want to delete all messages? This action cannot be undone.')">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-trash me-2"></i>Delete All
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.messages.mark.all.read') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-check-double me-2"></i>Mark All Read
                        </button>
                    </form>
                </div>
            </div>

            <!-- Messages Container -->
            <div id="messagesContainer">
                @if($messages->count() > 0)
                    <div id="messagesList">
                        @foreach($messages as $message)
                            <div class="card mb-3 message-card {{ !$message->read ? 'border-primary' : '' }}" data-message-id="{{ $message->id }}">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center mb-2">
                                                <h6 class="card-title mb-0 me-3">{{ $message->first_name }} {{ $message->last_name }}</h6>
                                                {{ !$message->read ? '<span class="badge bg-primary">New</span>' : '' }}
                                                <small class="text-muted ms-auto">{{ $message->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="card-text text-muted mb-1"><i class="fas fa-envelope me-2"></i>{{ $message->email }}</p>
                                            <p class="card-text mb-0"><strong>Subject:</strong> {{ $message->subject }}</p>
                                            <p class="card-text text-muted">{{ Str::limit($message->message, 150) }}</p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <button class="btn btn-outline-primary btn-sm mb-2" onclick="viewMessage({{ $message->id }})">
                                                <i class="fas fa-eye me-1"></i>View
                                            </button>
                                            <br>
                                            @if(!$message->read)
                                                <button type="button" class="btn btn-outline-success btn-sm mb-2" onclick="markAsRead({{ $message->id }})">
                                                    <i class="fas fa-check me-1"></i>Mark Read
                                                </button>
                                                <br>
                                            @endif
                                            <form method="POST" action="{{ route('admin.messages.delete', $message->id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="fas fa-trash me-1"></i>Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div id="noMessages" class="text-center py-5">
                        <i class="fas fa-envelope-open fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No messages yet</h4>
                        <p class="text-muted">When customers contact you, their messages will appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Message Detail Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Message Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="messageModalBody">
                    <!-- Message details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="deleteMessageBtn">
                        <i class="fas fa-trash me-2"></i>Delete Message
                    </button>
                </div>
            </div>
        </div>
    </div>

<script>
// View message details
function viewMessage(messageId) {
    // Fetch message details via AJAX
    fetch(`/admin/messages/${messageId}/json`)
        .then(response => response.json())
        .then(message => {
            const modalBody = document.getElementById('messageModalBody');
            modalBody.innerHTML = `
                <div class="mb-3">
                    <label class="form-label fw-bold">Name:</label>
                    <p>${message.first_name} ${message.last_name}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Email:</label>
                    <p>${message.email}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Subject:</label>
                    <p>${message.subject}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Message:</label>
                    <p>${message.message.replace(/\n/g, '<br>')}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Date/Time:</label>
                    <p>${new Date(message.created_at).toLocaleString()}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Status:</label>
                    <p>${message.read ? 
                        '<span class="badge bg-success">Read</span>' : 
                        '<span class="badge bg-primary">Unread</span>'}</p>
                </div>
            `;
            
            // Set current message ID for delete button
            window.currentMessageId = messageId;
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('messageModal'));
            modal.show();
            
            // Mark as read if unread
            if (!message.read) {
                markAsRead(messageId);
            }
        })
        .catch(error => {
            console.error('Error fetching message:', error);
            alert('Error loading message details. Please try again.');
        });
}

// Mark message as read
function markAsRead(messageId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }

    fetch(`/admin/messages/${messageId}/mark-read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update UI
            const messageCard = document.querySelector(`[data-message-id="${messageId}"]`);
            if (messageCard) {
                messageCard.classList.remove('border-primary');
                const badge = messageCard.querySelector('.badge.bg-primary');
                if (badge) badge.remove();
                
                // Hide the Mark Read button
                const markReadButton = messageCard.querySelector('button[onclick*="markAsRead"]');
                if (markReadButton) {
                    markReadButton.style.display = 'none';
                    // Also hide the <br> tag after it
                    const nextElement = markReadButton.nextElementSibling;
                    if (nextElement && nextElement.tagName === 'BR') {
                        nextElement.style.display = 'none';
                    }
                }
            }
            
            // Update localStorage to reflect the read status
            let messages = JSON.parse(localStorage.getItem('contactMessages') || '[]');
            const messageIndex = messages.findIndex(msg => msg.id == messageId);
            if (messageIndex !== -1) {
                messages[messageIndex].read = true;
                localStorage.setItem('contactMessages', JSON.stringify(messages));
            }
            
            // Update the message badge with the count from backend
            if (data.unreadCount !== undefined) {
                const badge = document.getElementById('messageBadge');
                if (badge) {
                    if (data.unreadCount > 0) {
                        badge.textContent = data.unreadCount > 99 ? '99+' : data.unreadCount;
                        badge.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            } else {
                // Fallback to localStorage-based update
                updateMessageBadge();
            }
        }
    })
    .catch(error => {
        console.error('Error marking message as read:', error);
    });
}

// Delete message from modal
document.getElementById('deleteMessageBtn').addEventListener('click', function() {
    if (window.currentMessageId) {
        if (confirm('Are you sure you want to delete this message?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/messages/${window.currentMessageId}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    }
});

// Display flash messages
function displayFlashMessages() {
    @if(session('success'))
        const successAlert = document.createElement('div');
        successAlert.className = 'alert alert-success alert-dismissible fade show position-fixed';
        successAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        successAlert.innerHTML = `
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(successAlert);
        
        setTimeout(() => {
            successAlert.remove();
        }, 5000);
    @endif
    
    @if(session('error'))
        const errorAlert = document.createElement('div');
        errorAlert.className = 'alert alert-danger alert-dismissible fade show position-fixed';
        errorAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        errorAlert.innerHTML = `
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(errorAlert);
        
        setTimeout(() => {
            errorAlert.remove();
        }, 5000);
    @endif
}

// Mark all messages as read
function markAllAsRead() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }

    fetch('/admin/messages/mark-all-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update all message cards to remove unread styling
            document.querySelectorAll('.message-card.border-primary').forEach(card => {
                card.classList.remove('border-primary');
                const badge = card.querySelector('.badge.bg-primary');
                if (badge) badge.remove();
            });
            
            // Update localStorage to mark all as read
            let messages = JSON.parse(localStorage.getItem('contactMessages') || '[]');
            messages = messages.map(msg => ({ ...msg, read: true }));
            localStorage.setItem('contactMessages', JSON.stringify(messages));
            
            // Update the message badge
            const badge = document.getElementById('messageBadge');
            if (badge) {
                badge.style.display = 'none';
            }
            
            // Show success message
            const successAlert = document.createElement('div');
            successAlert.className = 'alert alert-success alert-dismissible fade show position-fixed';
            successAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            successAlert.innerHTML = 'All messages marked as read!';
            document.body.appendChild(successAlert);
            
            setTimeout(() => {
                successAlert.remove();
            }, 3000);
        }
    })
    .catch(error => {
        console.error('Error marking all messages as read:', error);
        // Fallback to form submission
        const form = document.querySelector('form[action*="mark-all-read"]');
        if (form) form.submit();
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    displayFlashMessages();
    
    // Add event listener to "Mark All Read" button
    const markAllReadBtn = document.querySelector('form[action*="mark-all-read"] button[type="submit"]');
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function(e) {
            e.preventDefault();
            markAllAsRead();
        });
    }
    
    // Initialize localStorage with current message data from database
    @php
        $messagesData = $messages->map(function($message) {
            return [
                'id' => $message->id,
                'read' => (bool)$message->read,
                'created_at' => $message->created_at->toISOString()
            ];
        })->toArray();
    @endphp
    
    const messagesFromDb = @json($messagesData);
    localStorage.setItem('contactMessages', JSON.stringify(messagesFromDb));
    
    // Update the message badge with current unread count
    const badge = document.getElementById('messageBadge');
    if (badge) {
        const unreadCount = {{ $unreadCount }};
        if (unreadCount > 0) {
            badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
            badge.style.display = 'inline-block';
        } else {
            badge.style.display = 'none';
        }
    }
});
</script>

<style>
.message-card {
    transition: all 0.3s ease;
}

.message-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.message-card.border-primary {
    border-left: 4px solid #007bff !important;
    background-color: #f8f9ff;
}

.badge {
    font-size: 0.7rem;
}

.modal-body .form-label {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.modal-body p {
    margin-bottom: 1rem;
    line-height: 1.6;
}

#noMessages {
    color: #6c757d;
}

#loadingMessages {
    color: #6c757d;
}
</style>
@endsection
