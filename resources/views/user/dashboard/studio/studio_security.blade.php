@extends('user.layouts.master')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --light-green-bg: #EBF5F0;
        --dark-green: #004D40;
        --text-color: #333;
        --label-color: #868e96;
        --border-color: #ced4da;
    }

    .settings-page-wrapper {
        background-color: var(--light-green-bg);
        padding: 40px 20px;
        width: 100%;
        display: flex;
        justify-content: center;
        font-family: 'Inter', sans-serif;
    }

    .settings-card-container {
        background-color: #fff;
        border-radius: 24px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        width: 100%;
        max-width: 600px;
        padding: 24px;
        box-sizing: border-box;
    }

    .card-title-heading {
        text-align: center;
        font-size: 20px;
        font-weight: 600;
        color: #014122;
        margin-bottom: 32px;
    }

    .section-title {
        font-size: 16px;
        font-weight: 600;
        margin-top: 32px;
        margin-bottom: 16px;
    }

    .info-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #5e8082;
        border-radius: 12px;
        padding: 10px 16px;
        margin-bottom: 16px;
    }

    .info-content {
        flex-grow: 1;
    }

    .info-content .label {
        display: block;
        font-size: 12px;
        color: #5E8082;
        margin-bottom: 2px;
    }

    .info-content .value {
        font-size: 14px;
        font-weight: 500;
        color: #333333;
    }

    .social-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .social-info img {
        width: 32px;
        height: 32px;
    }

    .action-link {
        background: none;
        border: none;
        color: #014122;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        padding: 0 0 0 10px;
        text-decoration: underline;
    }

    .save-changes-container {
        text-align: center;
        margin-top: 32px;
    }

    .save-changes-btn {
        background-color: #014122;
        color: #fff;
        border: none;
        padding: 14px 40px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
    }

    /* --- MODAL STYLES --- */
    .modal-overlay {
        z-index: 9999;
        /* higher than sidebar z-index */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        display: none;
        justify-content: center;
        align-items: center;
    }

    .modal-content-box {
        background: #fffdfd;
        padding: 24px;
        border-radius: 24px;
        width: 90%;
        max-width: 450px;
        position: relative;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: var(--dark-green);
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        color: #aaa;
    }

    .modal-body .info-box {
        padding: 8px 16px;
        /* Adjust padding for inputs */
    }

    .modal-body .info-content input {
        width: 100%;
        border: none;
        background: transparent;
        padding: 0;
        font-size: 15px;
        font-weight: 500;
    }

    .modal-body .info-content input:focus {
        outline: none;
    }

    .modal-footer {
        text-align: right;
        margin-top: 24px;
    }

    .modal-footer button {
        background-color: var(--dark-green);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
    }
</style>

@section('content')
    <div class="settings-page-wrapper">
        <div class="settings-card-container">

            <h2 class="card-title-heading">Login & Security</h2>

            <!-- Password Section -->
            <div class="info-box">
                <div class="info-content">
                    <span class="label">Last Update</span>
                    <span class="value">Last Updated 4 days ago</span>
                </div>
                <button type="button" id="openPasswordModal" class="action-link">Update</button>
            </div>

            <!-- Social Accounts Section -->
            <h3 class="section-title">Social Accounts</h3>
            <div class="info-box">
                <div class="info-content social-info">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram">
                    <div>
                        <span class="label">Instagram</span>
                        <span class="value" style="color: green;">Connected</span>
                    </div>
                </div>
                <a href="#" class="action-link">Disconnect</a>
            </div>
            <div class="info-box">
                <div class="info-content social-info">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/2021_Facebook_icon.svg" alt="Facebook">
                    <div>
                        <span class="label">Facebook</span>
                        <span class="value" style="color: green;">Connected</span>
                    </div>
                </div>
                <a href="#" class="action-link">Disconnect</a>
            </div>

            <!-- Deactivate Account Section -->
            <h3 class="section-title">Deactivate your account</h3>
            <div class="info-box">
                <div class="info-content">
                    <span class="label">Deactivate your account</span>
                    <span class="value">This action cannot be undone</span>
                </div>
                <a href="#" class="action-link" style="color: #dc3545;">Deactivate</a>
            </div>

            <!-- Save Button -->
            <div class="save-changes-container">
                <button class="save-changes-btn">Save Changes</button>
            </div>

        </div>
    </div>

    <!-- Password Change Modal HTML (Initially Hidden) -->
    <div id="passwordModal" class="modal-overlay">
        <div class="modal-content-box">
            <div class="modal-header">
                <h3>Change Password</h3>
                <button class="close-modal">&times;</button>
            </div>
            <form>
                {{--                @csrf --}}
                <div class="modal-body">
                    <div class="info-box">
                        <div class="info-content">
                            <label class="label">New Password</label>
                            <input type="password" name="password" placeholder="Enter new password" required>
                        </div>
                    </div>
                    <div class="info-box">
                        <div class="info-content">
                            <label class="label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" placeholder="Confirm new password" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit">Update Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const modal = $('#passwordModal');
            const openBtn = $('#openPasswordModal');
            const closeBtn = $('.close-modal');

            // Modal ko open karne ke liye
            openBtn.on('click', function() {
                modal.css('display', 'flex').hide().fadeIn(300);
            });

            // Modal ko close button se band karne ke liye
            closeBtn.on('click', function() {
                modal.fadeOut(300);
            });

            // Modal ke bahar click karne par usay band karne ke liye
            modal.on('click', function(event) {
                if ($(event.target).is(modal)) {
                    modal.fadeOut(300);
                }
            });
        });
    </script>
@endsection
