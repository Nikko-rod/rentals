<div id="edit-modal" class="modal">
    <div class="modal-content">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Edit User</h3>
            <button onclick="closeModal('edit-modal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="edit-user-form" class="space-y-4">
            @csrf
            @method('PATCH')
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">
                        First Name
                    </label>
                    <input type="text" 
                           id="edit_first_name" 
                           name="first_name" 
                           class="form-input w-full" 
                           required>
                </div>
                
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Last Name
                    </label>
                    <input type="text" 
                           id="edit_last_name" 
                           name="last_name" 
                           class="form-input w-full" 
                           required>
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email Address
                </label>
                <input type="email" 
                       id="edit_email" 
                       name="email" 
                       class="form-input w-full" 
                       required>
            </div>

            <div>
                <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-1">
                    Contact Number
                </label>
                <input type="tel" 
                       id="edit_contact_number" 
                       name="contact_number" 
                       class="form-input w-full" 
                       required>
            </div>

            <div class="pt-4 border-t">
                <div class="flex justify-end gap-3">
                    <button type="button" 
                            onclick="closeModal('edit-modal')" 
                            class="btn btn-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function showEditModal(userId) {
    currentUserId = userId;
    
    // Fetch user data
    fetch(`/admin/users/${userId}/edit`)
        .then(response => response.json())
        .then(user => {
            document.getElementById('edit_first_name').value = user.first_name;
            document.getElementById('edit_last_name').value = user.last_name;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_contact_number').value = user.contact_number;
            showModal('edit-modal');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load user data');
        });
}

document.getElementById('edit-user-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!currentUserId) return;

    const formData = new FormData(this);
    
    fetch(`/admin/users/${currentUserId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => {
        if (response.ok) {
            location.reload();
        } else {
            throw new Error('Failed to update user');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update user. Please try again.');
    });
});
</script>