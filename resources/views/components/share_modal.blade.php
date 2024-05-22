@once
    <script></script>
@endonce
<div class="modal fade" id="shareModalToggle" aria-hidden="true" aria-labelledby="shareModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalToggleLabel">Share to</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <textarea class="form-control form-control-lg" style="max-height: 40vh; min-height: 30vh; height: auto;" readonly id="shareCaption"></textarea>

                <div class="d-flex flex-wrap gap-2 my-2">
                    <!-- The button used to copy the caption -->
                    <button class="btn btn-secondary copy-btn">
                        <i class="fas fa-copy"></i>
                        Copy
                    </button>
                    <!-- button to share to linkedIn -->
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=###" target="_blank"
                    style=" background-color: #0a66c2; "
                        rel="noopener noreferrer" id="shareLinkedin" class="btn btn-primary">
                        <i class="fab fa-linkedin-in"></i> LinkedIn
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=###" class="btn btn-primary border-0"
                    style=" background-color: #3b5998; "
                    id="shareFacebook" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-facebook-f"></i> Facebook
                    </a>
                    <a target="_blank" rel="noopener noreferrer" class="btn btn-dark btn-outline-light" id="shareTwitter"
{{--                        style=" background-color: #1da1f2; "--}}
                        href="https://twitter.com/intent/tweet?text=#">
                        <i class="fab fa-x-twitter"></i> (Twitter)
                    </a>
                    <a target="_blank" rel="noopener noreferrer" class="btn btn-success" id="shareWhatsapp"
                        href="#">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>

                    <button class="btn btn-primary navi-share">
                        <i class="fas fa-share-alt"></i>
                        More
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
