    </div>
       
    <!-- row 5 -->
    <footer class="row">
        <p>Southingam University. Enlightment and Self-Reliance</p>
        <p>(c) Copyright 2015. Managed by Anthoo Padua Tech. Co.</p>
    </footer>

</div> <!-- end container -->

<!-- javascript -->
    <!-- <script src="http://code.jquery.com/jquery-latest.min.js"></script> -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(function () {
            $('.nav-tabs a:first').tab('show');
        });
    </script>
</body>
</html>
<?php
    if(isset($connection)){
        mysql_close($connection);
    }
?>