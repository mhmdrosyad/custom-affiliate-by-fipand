<div class="wrap">
    <h1>Affiliate Commission Settings</h1>
    <form method="POST">
        <table class="form-table" id="commission-rules-table">
            <thead>
                <tr>
                    <th>Membership Type</th>
                    <th>Commission Rate (%)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commission_rules as $index => $rule): ?>
                    <tr>
                        <td>
                            <select name="commission_rules[<?php echo $index; ?>][membership_id]">
                                <?php foreach ($memberships as $membership): ?>
                                    <option value="<?php echo $membership->ID; ?>" <?php selected($membership->ID, $rule['membership_id']); ?>>
                                        <?php echo $membership->post_title; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="commission_rules[<?php echo $index; ?>][rate]" value="<?php echo esc_attr($rule['rate']); ?>" step="0.01" min="0">
                        </td>
                        <td>
                            <button type="button" class="button remove-row">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p>
            <button type="button" class="button add-row">Add New Rule</button>
        </p>
        <p>
            <input type="submit" class="button button-primary" value="Save Changes">
        </p>
    </form>
</div>