document.addEventListener('DOMContentLoaded', function(){

    document.querySelectorAll('.card-gold').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-6px)';
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
        });
    });

});









