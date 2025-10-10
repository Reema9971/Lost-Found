<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
redirectIfNotLoggedIn();
?>

<?php include 'includes/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card report-form">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Report Lost/Found Item</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="process-report.php" enctype="multipart/form-data">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Item Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <option value="electronics">Electronics</option>
                                    <option value="documents">Documents</option>
                                    <option value="jewelry">Jewelry</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4" required></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <input type="text" name="location" class="form-control" required>
                            </div>

                            <!-- <div class="col-md-6">
                                <label class="form-label">your phone number</label>
                                <input type="tel" name="Phone" class="form-control" pattern="[0-9]{10}" required>
                            </div> -->

                            <div class="col-md-6">
                                <label class="form-label">Date</label>
                                <input type="date" name="lost_date" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" 
                                               id="lost" value="lost" checked>
                                        <label class="form-check-label" for="lost">
                                            Lost Item
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" 
                                               id="found" value="found">
                                        <label class="form-check-label" for="found">
                                            Found Item
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                 <label for="image" class="form-label">Upload Image</label>
                                 <input class="form-control" type="file" name="image" id="image">
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100 py-2">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Report
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>