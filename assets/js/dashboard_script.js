
// Sidebar toggle functionality
const sidebar = document.querySelector('.sidebar');
const toggleSidebar = () => {
    sidebar.classList.toggle('open');
}

document.querySelector('.toggle-sidebar').addEventListener('click', toggleSidebar);

