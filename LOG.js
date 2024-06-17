document.addEventListener('DOMContentLoaded', () => {
    const expandableFilter = document.getElementById('expandableFilter');
    const expandButton = document.getElementById('expandButton');
    const filterButton = document.getElementById('filterButton');
    const resetButton = document.getElementById('resetButton');
    const searchInput = document.getElementById('searchInput');
    const columnSelect = document.getElementById('columnSelect');

    expandButton.addEventListener('click', () => {
        expandableFilter.classList.toggle('active');
    });

    filterButton.addEventListener('click', () => {
        const searchText = searchInput.value.toLowerCase();
        const columnIndex = columnSelect.selectedIndex;
        const table = document.getElementById('logTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            const cellValue = cells[columnIndex].textContent.toLowerCase();
            if (cellValue.includes(searchText)) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    });

    resetButton.addEventListener('click', () => {
        searchInput.value = '';
        const rows = document.getElementById('logTable').getElementsByTagName('tr');
        for (let i = 1; i < rows.length; i++) {
            rows[i].style.display = '';
        }
    });
});
