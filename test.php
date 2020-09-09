<form name="form1" onsubmit="checkForm(); return false;" novalidate>
    <input type="hidden" name="sid" value="<?= $row['sid'] ?>">
    
    <div class="form-group">
        <label for="name"><span class="red-stars">**</span> name</label>
        <input type="text" class="form-control" id="name" name="name" required value="<?= htmlentities($row['name']) ?>">
        <small class="form-text error-msg"></small>
    </div>
    <div class="form-group">
        <label for="email"><span class="red-stars">**</span> email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= htmlentities($row['email']) ?>">
        <small class="form-text error-msg"></small>
    </div>
    <div class="form-group">
        <label for="mobile"><span class="red-stars">**</span> mobile</label>
        <input type="tel" class="form-control" id="mobile" name="mobile" value="<?= htmlentities($row['mobile']) ?>" pattern="09\d{2}-?\d{3}-?\d{3}">
        <small class="form-text error-msg"></small>
    </div>
    <div class="form-group">
        <label for="birthday">birthday</label>
        <input type="date" class="form-control" id="birthday" name="birthday" value="<?= htmlentities($row['birthday']) ?>">
    </div>
    <div class="form-group">
        <label for="address">address</label>
        <textarea class="form-control" name="address" id="address" cols="30" rows="3"><?= htmlentities($row['address']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>