<div id="permit-modal" class="modal">
    <div class="modal-content">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Review Business Permit</h3>
            <button onclick="closeModal('permit-modal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="mb-6">
            <div class="border rounded-lg overflow-hidden bg-gray-50">
                <iframe id="permit-preview" class="w-full h-[32rem]"></iframe>
            </div>
        </div>

        <div class="rejection-form hidden mb-6">
            <label for="rejection-reason" class="block text-sm font-medium text-gray-700 mb-2">
                Rejection Reason
            </label>
            <select id="rejection-reason" class="form-select w-full">
                <option value="">Select a reason</option>
                <option value="blurry">Document is blurry or unreadable</option>
                <option value="corrupt_file">File appears to be corrupted</option>
                <option value="expired_document">Document has expired</option>
                <option value="invalid_document">Invalid document type</option>
                <option value="incomplete_information">Missing required information</option>
            </select>
            <p class="text-sm text-gray-500 mt-1">
                This reason will be shown to the landlord
            </p>
        </div>

        <div class="flex items-center justify-end gap-3">
            <button onclick="approvePermit()" class="btn btn-success">
                <i class="fas fa-check"></i>
                <span>Approve</span>
            </button>
            <button onclick="toggleRejectionForm()" id="reject-btn" class="btn btn-danger">
                <i class="fas fa-times"></i>
                <span>Reject</span>
            </button>
            <button onclick="confirmReject()" id="confirm-reject-btn" class="btn btn-danger hidden">
                <i class="fas fa-times"></i>
                <span>Confirm Rejection</span>
            </button>
            <button onclick="closeModal('permit-modal')" class="btn btn-secondary">
                Cancel
            </button>
        </div>
    </div>
</div>

<script>
function toggleRejectionForm() {
    const rejectionForm = document.querySelector('.rejection-form');
    const rejectBtn = document.getElementById('reject-btn');
    const confirmRejectBtn = document.getElementById('confirm-reject-btn');
    
    rejectionForm.classList.toggle('hidden');
    rejectBtn.classList.toggle('hidden');
    confirmRejectBtn.classList.toggle('hidden');
}

function confirmReject() {
    const reason = document.getElementById('rejection-reason').value;
    if (!reason) {
        alert('Please select a rejection reason');
        return;
    }

    if (!currentUserId) return;
    
    fetch(`/admin/users/${currentUserId}/reject-permit`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ reason })
    }).then(response => {
        if (response.ok) {
            location.reload();
        } else {
            alert('Failed to reject permit. Please try again.');
        }
    });
}

function approvePermit() {
    if (!currentUserId) return;
    
    if (!confirm('Are you sure you want to approve this permit?')) return;

    fetch(`/admin/users/${currentUserId}/approve-permit`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(response => {
        if (response.ok) {
            location.reload();
        } else {
            alert('Failed to approve permit. Please try again.');
        }
    });
}
</script>