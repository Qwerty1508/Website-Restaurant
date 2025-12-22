document.addEventListener('DOMContentLoaded', () => {
    if (!document.querySelector('.cursor-dot')) {
        const dot = document.createElement('div');
        dot.className = 'cursor-dot';
        document.body.appendChild(dot);
    }
    if (!document.querySelector('.cursor-follower')) {
        const follower = document.createElement('div');
        follower.className = 'cursor-follower';
        document.body.appendChild(follower);
    }
    const cursorDot = document.querySelector('.cursor-dot');
    const cursorFollower = document.querySelector('.cursor-follower');
    let mouseX = 0, mouseY = 0;
    let cursorX = 0, cursorY = 0;
    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
        cursorDot.style.left = mouseX + 'px';
        cursorDot.style.top = mouseY + 'px';
    });
    function animateCursor() {
        cursorX += (mouseX - cursorX) * 0.15;
        cursorY += (mouseY - cursorY) * 0.15;
        cursorFollower.style.left = cursorX + 'px';
        cursorFollower.style.top = cursorY + 'px';
        requestAnimationFrame(animateCursor);
    }
    animateCursor();
    const interactables = document.querySelectorAll('a, button, input, textarea, select, .btn, .btn-magnetic, .nav-link, .dropdown-item');
    interactables.forEach(el => {
        el.addEventListener('mouseenter', () => {
            cursorFollower.classList.add('active');
            cursorDot.style.opacity = '0';
        });
        el.addEventListener('mouseleave', () => {
            cursorFollower.classList.remove('active');
            cursorDot.style.opacity = '1';
        });
    });
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.addedNodes.length) {
                const newInteractables = document.querySelectorAll('a, button, input, .btn');
                newInteractables.forEach(el => {
                });
            }
        });
    });
    document.body.addEventListener('mouseover', (e) => {
        if (e.target.closest('a, button, input, textarea, select, .btn, .nav-link')) {
            cursorFollower.classList.add('active');
            cursorDot.style.opacity = '0';
        }
    });
    document.body.addEventListener('mouseout', (e) => {
        if (e.target.closest('a, button, input, textarea, select, .btn, .nav-link')) {
            cursorFollower.classList.remove('active');
            cursorDot.style.opacity = '1';
        }
    });
});