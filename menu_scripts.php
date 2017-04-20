<!-- Script so the menu will follow -->
<script>
    $(document)
      .ready(function () {
          // fix menu when passed
          $('.masthead')
            .visibility({
                once: false,
                onBottomPassed: function () {
                    $('.fixed.menu').transition('fade in');
                },
                onBottomPassedReverse: function () {
                    $('.fixed.menu').transition('fade out');
                }
            })
          ;
          // create sidebar and attach to menu open
          $('.ui.sidebar')
            .sidebar('attach events', '.toc.item')
          ;
      })
    ;
</script>
<script>
window.onload = function() {
    // Setup search

    <?php
    include_once "helper.php";

    global $db;
    $query = "SELECT media_id, title, type, upload_date, tags, description FROM media";
    $result = mysqli_query($db, $query);
    $rows = array();

    while($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    echo "var content = " . json_encode($rows) . ";";
    ?>
    $('.ui.search')
        .search({
            type: 'standard',
            source: content,
            searchFields : [
                'title','description', 
            ],

        onSelect: function(result, response) {
            location.href="player.php?media_id=" + result.media_id
        },
        searchFullText: false
        });
}
</script>
