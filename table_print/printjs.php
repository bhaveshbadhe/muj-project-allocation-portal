


<script>
    
    
$(document).ready(function () {
    let table = $('.searchtable').DataTable({
        "paging": true,
        "searching": false, // Keep disabled for custom search
        "order": [[0, "asc"]],
        "lengthMenu": [[10, 50, 100, 500], [10, 50, 100, 500]], // Sorting filter
        "dom": 'lrtip' // Removes default search box
    });

    

    // Search functionality for any keyword, word, or number
    function searchTable(searchValue) {
        searchValue = searchValue.toLowerCase();
        table.rows().every(function () {
            let row = this.node();
            let found = false;
            $(row).find('td').each(function () {
                if ($(this).text().toLowerCase().includes(searchValue)) {
                    found = true;
                }
            });
            $(row).toggle(found);
        });
    }

    // Event listener for search input
    $('#searchInput').on('input', function () {
        searchTable(this.value);
    });
    $('.dataTables_length').css( 'margin-top', '10px');
    $('.dataTables_length').css( 'margin-bottom', '10px');
});




// 1. Full Table Export with Black Header
function exportFullExcelTable(tableId) {
    const table = document.getElementById(tableId);
    const rows = [];
    
    table.querySelectorAll("tr").forEach((row) => {
        const rowData = [];
        row.querySelectorAll("td, th").forEach((cell) => {
            rowData.push(cell.innerText);
        });
        rows.push(rowData);
    });

    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.aoa_to_sheet(rows);
      // Get the range of the worksheet
      const range = XLSX.utils.decode_range(ws['!ref']);

         // Style objects
    const borderStyle = {
        top: { style: 'thin', color: { rgb: '000000' } },
        bottom: { style: 'thin', color: { rgb: '000000' } },
        left: { style: 'thin', color: { rgb: '000000' } },
        right: { style: 'thin', color: { rgb: '000000' } }
    };

    
    // Black header styling
    const headerStyle = {
        font: {
            bold: true,
            color: { rgb: "000000" }
        },
        alignment: {
            horizontal: "center",
            vertical: "center"
        },
        border: borderStyle,
        fill: {
            fgColor: { rgb: "ECECEC" }
        }
    };

     const cellStyle = {
        alignment: {
            horizontal: "center",
            vertical: "center"
        },
        border: borderStyle
    };

   // Apply styles to all cells
   for (let R = range.s.r; R <= range.e.r; ++R) {
        for (let C = range.s.c; C <= range.e.c; ++C) {
            const cell_address = XLSX.utils.encode_cell({ r: R, c: C });
            
            if (!ws[cell_address]) {
                ws[cell_address] = { v: '', t: 's' };
            }

            ws[cell_address].s = R === 0 ? headerStyle : cellStyle;
        }
    }

    // Add spacing (column widths)
    ws['!cols'] = rows[0].map(() => ({ wch: 20 }));

    XLSX.utils.book_append_sheet(wb, ws, "Excel Data");
    XLSX.writeFile(wb, `Excel_${new Date().toISOString().split('T')[0]}.xlsx`);
}

function printFullTable(tableId) {
    let table = document.getElementById(tableId);
    if (!table) {
        console.error("Table not found:", tableId);
        return;
    }

    let newWindow = window.open("", "_blank");
    let tableHTML = `
        <html>
        <head>
            <title>Print Table</title>
            <style>
                body { font-family: Arial, sans-serif; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid black; padding: 8px; text-align: center; }
                th { background-color: #f2f2f2; }
            </style>
        </head>
        <body>
            <h2>Table Data</h2>
            <table>${table.innerHTML}</table>
        </body>
        </html>`;

    newWindow.document.write(tableHTML);
    newWindow.document.close();
    newWindow.print();
    newWindow.close();
}


// 3. Export Without Last Column
function exportExcelWithoutLastColumn(tableId) {
    const table = document.getElementById(tableId);
    const rows = [];
    
    table.querySelectorAll("tr").forEach((row) => {
        const rowData = [];
        const cells = row.querySelectorAll("td, th");
        cells.forEach((cell, index) => {
            if(index < cells.length - 1) rowData.push(cell.innerText);
        });
        rows.push(rowData);
    });

    // Same styling as full export
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.aoa_to_sheet(rows);
      // Style objects
      const borderStyle = {
        top: { style: 'thin', color: { rgb: '000000' } },
        bottom: { style: 'thin', color: { rgb: '000000' } },
        left: { style: 'thin', color: { rgb: '000000' } },
        right: { style: 'thin', color: { rgb: '000000' } }
    };

    
    // Black header styling
    const headerStyle = {
        font: {
            bold: true,
            color: { rgb: "000000" }
        },
        alignment: {
            horizontal: "center",
            vertical: "center"
        },
        border: borderStyle,
        fill: {
            fgColor: { rgb: "ECECEC" }
        }
    };

     const cellStyle = {
        alignment: {
            horizontal: "center",
            vertical: "center"
        },
        border: borderStyle
    };


    // Set column widths
    ws['!cols'] = Array(rows[0].length).fill({ wch: 20 });


    XLSX.utils.book_append_sheet(wb, ws, "Excel Data");
    XLSX.writeFile(wb, `Excel_${new Date().toISOString().split('T')[0]}.xlsx`);
}

// 4. Print Without Last Column
function printTableWithoutLastColumn(tableId) {
    const table = document.getElementById(tableId).cloneNode(true);
    
    // Remove last column
    table.querySelectorAll("tr").forEach(row => {
        const cells = row.querySelectorAll("th, td");
        if(cells.length > 0) cells[cells.length - 1].remove();
    });

    const printWindow = window.open('width=800,height=600');
    printWindow.document.write(`
        <html>
            <head>
                <title>Print Table</title>
                <style>
                    body { margin: 20px; }
                    table { 
                        border-collapse: collapse; 
                        width: 100%;
                    
                    }
                    th, td { 
                        border: 1px solid #000; 
                        padding: 12px;
                        text-align: center;
                    }
                    th { 
                        background-color:rgb(255, 255, 255); 
                        color: black; 
                        font-weight: bold;
                        font-size:18px;
                   
                    }
                </style>
            </head>
            <body>
                <h2 style="color: #000; text-align: center; margin-bottom: 25px;">
                   Print Table
                </h2>
                ${table.outerHTML}
            </body>
        </html>
    `);
    
    printWindow.document.close();
    printWindow.print();
}



</script>



<!---------------button to print or export table ---------------------->
<!-- 
<div style="display: flex; gap: 10px;">
    <button onclick="exportFullExcelTable('tableId')" class="btn">
        <i class="fa-solid fa-file-excel"></i> Full Export
    </button>
    <button onclick="printFullTable('tableId')" class="btn">
        <i class="fa-solid fa-print"></i> Full Print
    </button>
    <button onclick="exportExcelWithoutLastColumn('tableId')" class="btn">
        <i class="fa-solid fa-file-excel"></i> Export Without Action
    </button>
    <button onclick="printTableWithoutLastColumn('tableId')" class="btn">
        <i class="fa-solid fa-print"></i> Print Without Action
    </button>
</div> -->