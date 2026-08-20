
        
        // Dropdown Toggle
        document.querySelector('.profile-dropdown').addEventListener('click', function(e) {
            e.stopPropagation();
            const menu = this.querySelector('.dropdown-menu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.style.display = 'none';
            });
        });
    
        // File input handler
        document.getElementById('file-input').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'No file chosen';
            document.getElementById('file-name').textContent = fileName;
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const inputs = this.querySelectorAll('[required]');
            let valid = true;
            
            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    input.classList.add('invalid');
                    valid = false;
                }
            });
            
            if (!valid) e.preventDefault();
        });

        // Input validation styling
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('input', function() {
                if (this.checkValidity()) {
                    this.classList.remove('invalid');
                }
            });
        });

        // Add red border to invalid inputs
        const style = document.createElement('style');
        style.textContent = `
            .invalid {
                border-color: var(--error) !important;
                box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.2) !important;
            }
        `;
        document.head.appendChild(style);
    