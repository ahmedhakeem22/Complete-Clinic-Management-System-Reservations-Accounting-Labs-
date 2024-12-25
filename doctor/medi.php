<?php
// medi.php
// Ensure removal of <html>, <head>, and <body> elements
?>

<div class="container">
    <h2 class="text-center mb-4" style="background-color:#00b3b3; color:white; padding:10px; border-radius:5px;">
        Enter Prescribed Medications Information
    </h2>

    <!-- Removed <form> tags to prevent nested forms -->

    <div class="form-group">
        <label for="pat_id" style="background-color:#737373; color:white; padding:10px; border-radius:5px;">
            Patient Number
        </label>
        <input type="number" name="pat_id" id="pat_id" class="form-control" placeholder="Patient ID" required>
    </div>

    <div id="drugs-container">
        <div class="drug-item border p-3 mb-3">
            <h5 class="mb-3">Medication #1</h5>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="med_name_1">Medication Name</label>
                    <input type="text" name="med_name[]" id="med_name_1" class="form-control" placeholder="Name" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="quantity_1">Quantity</label>
                    <input type="number" name="quantity[]" id="quantity_1" class="form-control" placeholder="Quantity" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Usage Method</label>
                    <div class="usage-options">
                        <?php foreach ($usageOptions as $value => $label): ?>
                            <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="usage[0][]" value="<?php echo $value; ?>" id="usage_<?php echo $value; ?>_0">
<label class="form-check-label" for="usage_<?php echo $value; ?>_0"><?php echo $label; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <span class="remove-drug" style="cursor:pointer; color:red;">&times; Remove Medication</span>
        </div>
    </div>

    <button type="button" id="add-drug-med" class="btn btn-info mb-3">Add New Medication</button>

    <div class="form-group">
        <label style="background-color:#737373; color:white; padding:10px; border-radius:5px;">
            Prescription Date
        </label>
        <input type="text" class="form-control" value="<?php echo $pat_date; ?>" readonly>
    </div>

</div>
