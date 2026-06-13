// ===== BOOKSHELF APP.JS =====

document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle
    const toggleBtn = document.getElementById('toggleBtn');
    const sidebar   = document.getElementById('sidebar');
    const main      = document.getElementById('main');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('expanded');
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
                sidebar.classList.remove('collapsed');
                main.classList.remove('expanded');
            }
        });
    }

    // Auto-dismiss alerts
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            alert.style.transition = 'all 0.4s';
            setTimeout(() => alert.remove(), 400);
        }, 4000);
    });

    // Delete confirmation
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('আপনি কি নিশ্চিত? এই বইটি মুছে ফেলা হবে।')) {
                e.preventDefault();
            }
        });
    });

    // Image preview on cover upload
    const coverInput = document.getElementById('cover_image');
    if (coverInput) {
        coverInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    let preview = document.getElementById('cover-preview');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.id = 'cover-preview';
                        preview.style.cssText = 'max-width:200px;max-height:280px;border-radius:8px;margin-top:10px;box-shadow:0 4px 12px rgba(0,0,0,.15)';
                        coverInput.parentNode.appendChild(preview);
                    }
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Status quick update
    document.querySelectorAll('.status-select').forEach(sel => {
        sel.addEventListener('change', function() {
            const form = this.closest('form');
            if (form) form.submit();
        });
    });

    // Modal Open/Close
    document.querySelectorAll('[data-modal]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modalId = btn.getAttribute('data-modal');
            const modal = document.getElementById(modalId);
            if (modal) modal.classList.add('show');
        });
    });
    document.querySelectorAll('.modal-close, .modal-overlay').forEach(el => {
        el.addEventListener('click', function(e) {
            if (e.target === this) {
                this.closest('.modal-overlay')?.classList.remove('show');
                document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('show'));
            }
        });
    });
    document.querySelectorAll('.modal').forEach(m => {
        m.addEventListener('click', e => e.stopPropagation());
    });

    // Rating star hover
    document.querySelectorAll('.star-input').forEach(star => {
        star.addEventListener('change', function() {
            const val = this.value;
            document.querySelectorAll('.star-display').forEach((s,i) => {
                s.style.color = i < val ? '#f59e0b' : '#d1d5db';
            });
        });
    });

    // Import drag-drop
    const importBox = document.querySelector('.import-box');
    if (importBox) {
        importBox.addEventListener('dragover', e => { e.preventDefault(); importBox.style.borderColor = '#6366f1'; });
        importBox.addEventListener('dragleave', () => importBox.style.borderColor = '');
        importBox.addEventListener('drop', e => {
            e.preventDefault();
            importBox.style.borderColor = '';
            const file = e.dataTransfer.files[0];
            if (file) {
                const fileInput = importBox.querySelector('input[type=file]');
                if (fileInput) {
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    fileInput.files = dt.files;
                    importBox.querySelector('.import-filename').textContent = file.name;
                }
            }
        });
        importBox.addEventListener('click', () => importBox.querySelector('input[type=file]')?.click());
        const fileInput = importBox.querySelector('input[type=file]');
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                const fn = importBox.querySelector('.import-filename');
                if (fn && this.files[0]) fn.textContent = this.files[0].name;
            });
        }
    }

    // Chart - Monthly Spend (simple bar chart using CSS)
    buildCharts();
});

function buildCharts() {
    // Genre Donut (Canvas)
    const genreCanvas = document.getElementById('genreChart');
    if (genreCanvas && window.genreData) {
        const ctx = genreCanvas.getContext('2d');
        const colors = ['#6366f1','#f59e0b','#10b981','#3b82f6','#ef4444','#8b5cf6','#ec4899','#14b8a6','#f97316','#84cc16'];
        const total = window.genreData.reduce((a,b) => a + b.count, 0);
        let start = -Math.PI/2;
        window.genreData.forEach((g, i) => {
            const slice = (g.count / total) * 2 * Math.PI;
            ctx.beginPath();
            ctx.moveTo(100,100);
            ctx.arc(100,100,90,start,start+slice);
            ctx.closePath();
            ctx.fillStyle = colors[i % colors.length];
            ctx.fill();
            start += slice;
        });
        // Donut hole
        ctx.beginPath();
        ctx.arc(100,100,50,0,2*Math.PI);
        ctx.fillStyle = '#fff';
        ctx.fill();
        ctx.fillStyle = '#1e293b';
        ctx.font = 'bold 14px Hind Siliguri';
        ctx.textAlign = 'center';
        ctx.fillText(total, 100, 96);
        ctx.font = '11px Hind Siliguri';
        ctx.fillStyle = '#64748b';
        ctx.fillText('মোট বই', 100, 112);
    }

    // Monthly Spend Bar Chart
    const monthCanvas = document.getElementById('monthChart');
    if (monthCanvas && window.monthData) {
        const ctx2 = monthCanvas.getContext('2d');
        const data  = window.monthData;
        const max   = Math.max(...data.map(d=>d.total), 1);
        const W = monthCanvas.width, H = monthCanvas.height;
        const barW  = Math.floor(W / data.length) - 8;
        const padB  = 30, padT = 20;
        ctx2.clearRect(0,0,W,H);
        data.forEach((d,i) => {
            const barH = ((d.total/max) * (H-padB-padT));
            const x    = i*(barW+8)+4;
            const y    = H-padB-barH;
            const grad = ctx2.createLinearGradient(x,y,x,H-padB);
            grad.addColorStop(0,'#6366f1');
            grad.addColorStop(1,'#4f46e5');
            ctx2.fillStyle = grad;
            ctx2.beginPath();
            ctx2.roundRect?.(x,y,barW,barH,4) ?? ctx2.rect(x,y,barW,barH);
            ctx2.fill();
            ctx2.fillStyle = '#64748b';
            ctx2.font = '10px Hind Siliguri';
            ctx2.textAlign = 'center';
            ctx2.fillText(d.month_short, x+barW/2, H-padB+14);
        });
    }
}

// Delete with form
function deleteBook(id) {
    if (confirm('এই বইটি মুছে ফেলা হবে। নিশ্চিত?')) {
        const f = document.createElement('form');
        f.method = 'POST';
        f.action = '/books/'+id;
        f.innerHTML = `<input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                       <input type="hidden" name="_method" value="DELETE">`;
        document.body.appendChild(f);
        f.submit();
    }
}
