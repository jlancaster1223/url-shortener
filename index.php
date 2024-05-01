<style>
    body {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
    }

    .shortlink_wrapper {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #eeeeee;
    }

    .shortlink_inner {
        width: 70%;
        max-width: 800px;
        background-color: white;
        padding: 30px;
        border-radius: 20px;
    }

    h1 {
        margin-top: 0;
    }

    .shortlinkables {
        display: flex;
        flex-direction: column;
        border: 1px solid #eeeeee;
    }
    .shortlinkables .row {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
    }

    /* Change the background of every other row */
    .shortlinkables .row:nth-child(even) {
        background-color: #eeeeee;
    }
    .shortlinkables .row-header {
        background-color: black;
    }
    .shortlinkables .row-header a,
    .shortlinkables .row-header span {
        color: white;
        text-decoration: none;
    }
</style>

<div class="shortlink_wrapper">
    <div class="shortlink_inner">
        <h1>Shorty Generator</h1>
        <div class="shortlinkables">
            <form action="#" method="post">
                <div class="row">
                    <span>Long URL</span>
                    <input type="text" name="url" placeholder="https://example.com" />
                </div>
                <div class="row">
                    <input type="submit" name="submit" value="Shorten" />
                </div>
            </form>
        </div>
    </div>
</div>

<footer>
    <!-- include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $('form').submit(function(e) {
        
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: '/shorten.php',
            data: formData,
            success: function(response) {
                    $('.shortlinkables').children().not('form').remove();
                    $('.shortlinkables').append('<div class="row"><span>We\'ve shortened down the link by a lot!</span><div class="copylink" data-link="https://shorty.jameslancaster.co.uk/' + response + '">Click to Copy</div></div>');
            },
            error: function() {
                alert('An error occurred');
            }
        });
    });

    // On click of a copy link
    $(document).on('click', '.copylink', function() {
        
        var link = $(this).attr('data-link');
        navigator.clipboard.writeText(link);
        
        $(this).text('Copied!');
        
    });
    </script>
</footer>