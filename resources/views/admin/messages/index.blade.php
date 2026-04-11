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
                    <button class="btn btn-outline-danger btn-sm" onclick="deleteAllMessages()">
                        <i class="fas fa-trash me-2"></i>Delete All
                    </button>
                    <button class="btn btn-outline-success btn-sm" onclick="markAllAsRead()">
                        <i class="fas fa-check-double me-2"></i>Mark All Read
                    </button>
                </div>
            </div>

            <!-- Messages Container -->
            <div id="messagesContainer">
                <div class="text-center py-5" id="loadingMessages">
                    <i class="fas fa-spinner fa-spin fa-2x text-muted mb-3"></i>
                    <p class="text-muted">Loading messages...</p>
                </div>
                
                <div id="messagesList" style="display: none;">
                    <!-- Messages will be dynamically loaded here -->
                </div>
                
                <div id="noMessages" style="display: none;" class="text-center py-5">
                    <i class="fas fa-envelope-open fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No messages yet</h4>
                    <p class="text-muted">When customers contact you, their messages will appear here.</p>
                </div>
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
let messages = [];
let currentMessageId = null;

// Load messages from localStorage
function loadMessages() {
    messages = JSON.parse(localStorage.getItem('contactMessages') || '[]');
    renderMessages();
}

// Render messages list
function renderMessages() {
    const messagesList = document.getElementById('messagesList');
    const noMessages = document.getElementById('noMessages');
    const loadingMessages = document.getElementById('loadingMessages');
    
    loadingMessages.style.display = 'none';
    
    if (messages.length === 0) {
        messagesList.style.display = 'none';
        noMessages.style.display = 'block';
        return;
    }
    
    messagesList.style.display = 'block';
    noMessages.style.display = 'none';
    
    messagesList.innerHTML = messages.map(message => `
        <div class="card mb-3 message-card ${!message.read ? 'border-primary' : ''}" data-message-id="${message.id}">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center mb-2">
                            <h6 class="card-title mb-0 me-3">${message.name}</h6>
                            ${!message.read ? '<span class="badge bg-primary">New</span>' : ''}
                            <small class="text-muted ms-auto">${formatDate(message.timestamp)}</small>
                        </div>
                        <p class="card-text text-muted mb-1"><i class="fas fa-envelope me-2"></i>${message.email}</p>
                        <p class="card-text mb-0"><strong>Subject:</strong> ${message.subject}</p>
                        <p class="card-text text-muted">${message.message.substring(0, 150)}${message.message.length > 150 ? '...' : ''}</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-outline-primary btn-sm mb-2" onclick="viewMessage('${message.id}')">
                            <i class="fas fa-eye me-1"></i>View
                        </button>
                        <br>
                        ${!message.read ? `
                            <button class="btn btn-outline-success btn-sm mb-2" onclick="markAsRead('${message.id}')">
                                <i class="fas fa-check me-1"></i>Mark Read
                            </button>
                            <br>
                        ` : ''}
                        <button class="btn btn-outline-danger btn-sm" onclick="deleteMessage('${message.id}')">
                            <i class="fas fa-trash me-1"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
    
    updateMessageBadge();
}

// Format date
function formatDate(timestamp) {
    const date = new Date(timestamp);
    const now = new Date();
    const diffMs = now - date;
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMs / 3600000);
    const diffDays = Math.floor(diffMs / 86400000);
    
    if (diffMins < 1) return 'Just now';
    if (diffMins < 60) return `${diffMins} minutes ago`;
    if (diffHours < 24) return `${diffHours} hours ago`;
    if (diffDays < 7) return `${diffDays} days ago`;
    
    return date.toLocaleDateString();
}

// View message details
function viewMessage(messageId) {
    const message = messages.find(m => m.id === messageId);
    if (!message) return;
    
    currentMessageId = messageId;
    
    const modalBody = document.getElementById('messageModalBody');
    modalBody.innerHTML = `
        <div class="mb-3">
            <label class="form-label fw-bold">Name:</label>
            <p>${message.name}</p>
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
            <p>${message.message}</p>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Date/Time:</label>
            <p>${new Date(message.timestamp).toLocaleString()}</p>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Status:</label>
            <p>${message.read ? 
                '<span class="badge bg-success">Read</span>' : 
                '<span class="badge bg-primary">Unread</span>'}</p>
        </div>
    `;
    
    // Mark as read when viewing
    if (!message.read) {
        markAsRead(messageId);
    }
    
    const modal = new bootstrap.Modal(document.getElementById('messageModal'));
    modal.show();
}

// Mark message as read
function markAsRead(messageId) {
    const messageIndex = messages.findIndex(m => m.id === messageId);
    if (messageIndex !== -1) {
        messages[messageIndex].read = true;
        localStorage.setItem('contactMessages', JSON.stringify(messages));
        renderMessages();
    }
}

// Delete message
function deleteMessage(messageId) {
    if (confirm('Are you sure you want to delete this message?')) {
        messages = messages.filter(m => m.id !== messageId);
        localStorage.setItem('contactMessages', JSON.stringify(messages));
        
        // Close modal if it's open and this message is being viewed
        if (currentMessageId === messageId) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('messageModal'));
            if (modal) modal.hide();
        }
        
        renderMessages();
    }
}

// Delete all messages
function deleteAllMessages() {
    if (confirm('Are you sure you want to delete all messages? This action cannot be undone.')) {
        messages = [];
        localStorage.setItem('contactMessages', JSON.stringify(messages));
        renderMessages();
    }
}

// Mark all as read
function markAllAsRead() {
    messages.forEach(message => message.read = true);
    localStorage.setItem('contactMessages', JSON.stringify(messages));
    renderMessages();
}

// Update message badge (defined in header)
function updateMessageBadge() {
    const unreadCount = messages.filter(msg => !msg.read).length;
    const badge = document.getElementById('messageBadge');
    
    if (badge) {
        if (unreadCount > 0) {
            badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
            badge.style.display = 'inline-block';
        } else {
            badge.style.display = 'none';
        }
    }
}

// Delete message from modal
document.getElementById('deleteMessageBtn').addEventListener('click', function() {
    if (currentMessageId) {
        deleteMessage(currentMessageId);
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    loadMessages();
    
    // Listen for storage changes (for cross-tab updates)
    window.addEventListener('storage', function(e) {
        if (e.key === 'contactMessages') {
            loadMessages();
        }
    });
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
