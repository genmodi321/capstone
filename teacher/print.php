<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Table Example</title>
    <style>
        /* Add any additional styling if needed */
    </style>
</head>
<body>

<div  id ="printTable" >
    <h1>hi</h1>
    <style>
        table, td, tr, thead{
            border: 1px solid black;
        }
    </style>
    <table class="print-text" id="class"
    style="width: 100%; border: 1px solid black;">
    <thead style="border: 1px solid black;">
      <tr>
        <td class="text-center bold" colspan="20">Worksheets</td>
      </tr>
    </thead style="border: 1px solid black;">

    <tr style="border: 1px solid black;">
      <td class="text-center" colspan="2">Criteria</td>
      <td class="text-center" colspan="4">Quizzes (20%)</td>
      <td class="text-center">Total</td>
      <td class="text-center" colspan="4">Activites (20%)</td>
      <td class="text-center">Total</td>
      <td class="text-center" colspan="4">Projects (40%)</td>
      <td class="text-center">Total</td>
      <td class="text-center" colspan=2>Exams (20%)</td>
      <td class="text-center">Total</td>
      <td class="text-center">GPA</td>
    </tr>

    <tr>
      <td class="text-center">No. of Students</td>
      <td class="text-center">Name of Students</td>
      <td class="text-center">Q1 <br> (30)</td>
      <td class="text-center">Q2 <br> (30)</td>
      <td class="text-center">Q3 <br> (30)</td>
      <td class="text-center">Q4 <br> (30)</td>
      <td class="text-center">120</td>
      <td class="text-center">ACT. 1 <br> (50)</td>
      <td class="text-center">ACT. 2 <br> (50)</td>
      <td class="text-center">ACT. 3 <br> (50)</td>
      <td class="text-center">ACT. 4 <br> (50)</td>
      <td class="text-center"> 200</td>
      <td class="text-center"> P. 1 <br> (25)</td>
      <td class="text-center"> P. 2 <br> (25)</td>
      <td class="text-center"> P. 3 <br> (25)</td>
      <td class="text-center"> P. 4 <br> (25)</td>
      <td class="text-center">100</td>
      <td class="text-center">Midterms <br>(50)</td>
      <td class="text-center">Finals <br>(100)</td>
      <td class="text-center"> 150</td>
      <td class="text-center"></td>

    </tr>

    <tr>
      <td class="text-center grey-bg" colspan="2">Male</td>
    </tr>

    <tr>
      <td style="width:1% !important;">1.)</td>
      <td>Aquino, Leonard </td>
      <td class="text-center">15/30</td>
      <td class="text-center">15/30</td>
      <td class="text-center">15/30</td>
      <td class="text-center">15/30</td>
      <td class="text-center">60/120</td>
      <td class="text-center">20/50</td>
      <td class="text-center">45/50</td>
      <td class="text-center">50/50</td>
      <td class="text-center">50/50</td>
      <td class="text-center">165/200</td>
      <td class="text-center">25/25</td>
      <td class="text-center">25/25</td>
      <td class="text-center">25/25</td>
      <td class="text-center">25/25</td>
      <td class="text-center">100</td>
      <td class="text-center">50</td>
      <td class="text-center">100</td>
      <td class="text-center">150</td>
      <td class="text-center">1.5</td>
    </tr>
    <tr>
      <td style="width:1% !important;">2.)</td>
      <td>Abrajano, Joh Paulo </td>
      <td class="text-center">15/30</td>
      <td class="text-center">15/30</td>
      <td class="text-center">15/30</td>
      <td class="text-center">15/30</td>
      <td class="text-center">60/120</td>
      <td class="text-center">20/50</td>
      <td class="text-center">45/50</td>
      <td class="text-center">50/50</td>
      <td class="text-center">50/50</td>
      <td class="text-center">165/200</td>
      <td class="text-center">25/25</td>
      <td class="text-center">25/25</td>
      <td class="text-center">25/25</td>
      <td class="text-center">25/25</td>
      <td class="text-center">100</td>
      <td class="text-center">50</td>
      <td class="text-center">100</td>
      <td class="text-center">150</td>
      <td class="text-center">1.5</td>
    </tr>

    <tr>
      <td class="text-center grey-bg" colspan="2">Female</td>
    </tr>

    <tr>
      <td style="width:1% !important;">1.)</td>
      <td>Abdulla, Nurfitra </td>
      <td class="text-center">15/30</td>
      <td class="text-center">15/30</td>
      <td class="text-center">15/30</td>
      <td class="text-center">15/30</td>
      <td class="text-center">60/120</td>
      <td class="text-center">20/50</td>
      <td class="text-center">45/50</td>
      <td class="text-center">50/50</td>
      <td class="text-center">50/50</td>
      <td class="text-center">165/200</td>
      <td class="text-center">25/25</td>
      <td class="text-center">25/25</td>
      <td class="text-center">25/25</td>
      <td class="text-center">25/25</td>
      <td class="text-center">100</td>
      <td class="text-center">50</td>
      <td class="text-center">100</td>
      <td class="text-center">150</td>
      <td class="text-center">1.5</td>
    </tr>

  </table>
</div>

<button onclick="print('printTable')">Print Table</button>

<script>
    function print(divId) {
        var divToPrint = document.getElementById(divId).innerHTML;
        var iframe = document.createElement('iframe');

        iframe.style.position = 'absolute';
        iframe.style.width = '0px';
        iframe.style.height = '0px';
        iframe.style.border = 'none';

        document.body.appendChild(iframe);

        var doc = iframe.contentDocument || iframe.contentWindow.document;

        // Create and append style
        var style = doc.createElement('style');
        style.textContent = 'table, td, tr, thead { border: 1px solid black; border-collapse: collapse; } td, th { padding: 8px; }';
        doc.head.appendChild(style);

        // Add content to the iframe
        doc.body.innerHTML = divToPrint;

        // Print
        iframe.contentWindow.focus();
        iframe.contentWindow.print();

        // Remove iframe
        document.body.removeChild(iframe);
    }
</script>
    
    

</body>
</html>
