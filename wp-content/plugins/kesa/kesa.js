jQuery(document).ready(function(){
    jQuery('#kesaprint').on('click', function(){
      var divToPrint=document.getElementById('kesa-table');
      newWin= window.open('');
      newWin.document.write( '<div style="transform: rotate(90deg) translate(270px, 0px) scale(1.5,1.4); margin:auto;">' + divToPrint.outerHTML + '</div>' );
      newWin.print();
      newWin.close();
    });
  });
