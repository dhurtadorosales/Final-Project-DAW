$().ready(function() {
    $('#pdf').click(function() {
        var f = document.createElement('form');
        f.style.display = 'none';
        this.parentNode.appendChild(f);
        f.method = 'post';
        f.action = '<?php echo url_for('/pdf/')?>';
        var m = document.createElement('input');
        m.setAttribute('type', 'hidden');
        m.setAttribute('name', 'html');
        m.setAttribute('value', $('#job').html());
        f.appendChild(m);
        f.submit();
        return false;
    });
});