document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#commission-rules-table tbody');
    document.querySelector('.add-row').addEventListener('click', function() {
        const rowCount = tableBody.children.length;
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <select name="commission_rules[${rowCount}][membership_id]">
                    // Membership options will be dynamically generated from PHP template
                </select>
            </td>
            <td>
                <input type="number" name="commission_rules[${rowCount}][rate]" step="0.01" min="0">
            </td>
            <td>
                <button type="button" class="button remove-row">Delete</button>
            </td>
        `;
        tableBody.appendChild(newRow);
    });

    tableBody.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-row')) {
            event.target.closest('tr').remove();
        }
    });
});
