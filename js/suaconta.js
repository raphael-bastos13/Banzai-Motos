document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('a[href="#personal-data"]').addEventListener("click", function(event) {
        event.preventDefault();
        fetch('get_personal_data.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('personal-data').innerHTML = data;
            });
    });

    document.addEventListener('DOMContentLoaded', function() {
        function hideAllContents() {
            const contents = document.querySelectorAll('.content');
            contents.forEach(function(content) {
                content.style.display = 'none';
            });
        }
    
        function showContent(contentId) {
            hideAllContents();
            document.getElementById(contentId).style.display = 'block';
        }
    
        document.getElementById('link-personal-data').addEventListener('click', function(event) {
            event.preventDefault();
            showContent('personal-data');
        });
    
        document.getElementById('link-addresses').addEventListener('click', function(event) {
            event.preventDefault();
            showContent('addresses');
        });
    
        document.getElementById('link-alter-password').addEventListener('click', function(event) {
            event.preventDefault();
            showContent('alter-password');
        });
    
        document.getElementById('link-orders').addEventListener('click', function(event) {
            event.preventDefault();
            showContent('orders');
        });
    });
    
    

    

    
});
