// dashboardCharts.js - Handle Charts Rendering

document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard Charts JS loaded');
    
    // ============ PIE CHART - Komposisi Anggota ============
    const pieChartCtx = document.getElementById('pieChart');
    if (pieChartCtx && window.pieChartData) {
        const pieChart = new Chart(pieChartCtx, {
            type: 'pie',
            data: {
                labels: window.pieChartData.labels,
                datasets: [{
                    data: window.pieChartData.values,
                    backgroundColor: [
                        '#3182CE', // Dosen
                        '#38A169', // Asisten Lab
                        '#D69E2E', // Mahasiswa Magang
                        '#805AD5'  // Admin
                    ],
                    borderColor: '#FFFFFF',
                    borderWidth: 2,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                family: 'Poppins, sans-serif',
                                size: 12
                            },
                            color: '#2D3748',
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            family: 'Poppins, sans-serif',
                            size: 12
                        },
                        bodyFont: {
                            family: 'Poppins, sans-serif',
                            size: 12
                        },
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 1000
                }
            }
        });
        
        // Filter untuk Pie Chart
        const pieChartFilter = document.getElementById('pieChartFilter');
        if (pieChartFilter) {
            pieChartFilter.addEventListener('change', function() {
                const filterValue = this.value;
                
                if (filterValue === 'all') {
                    pieChart.data.labels = window.pieChartData.labels;
                    pieChart.data.datasets[0].data = window.pieChartData.values;
                } else if (filterValue === 'dosen') {
                    pieChart.data.labels = ['Dosen'];
                    pieChart.data.datasets[0].data = [window.pieChartData.values[0] || 0];
                } else if (filterValue === 'mahasiswa') {
                    pieChart.data.labels = ['Asisten Lab', 'Mahasiswa Magang'];
                    pieChart.data.datasets[0].data = [
                        window.pieChartData.values[1] || 0,
                        window.pieChartData.values[2] || 0
                    ];
                }
                
                pieChart.update();
            });
        }
    }
    
    // ============ BAR CHART - Aktivitas Publikasi ============
    const barChartCtx = document.getElementById('barChart');
    if (barChartCtx && window.barChartData) {
        const barChart = new Chart(barChartCtx, {
            type: 'bar',
            data: {
                labels: window.barChartData.months,
                datasets: [
                    {
                        label: 'Berita',
                        data: window.barChartData.berita,
                        backgroundColor: '#3182CE',
                        borderColor: '#3182CE',
                        borderWidth: 1,
                        borderRadius: 4
                    },
                    {
                        label: 'Agenda',
                        data: window.barChartData.agenda,
                        backgroundColor: '#38A169',
                        borderColor: '#38A169',
                        borderWidth: 1,
                        borderRadius: 4
                    },
                    {
                        label: 'Pengumuman',
                        data: window.barChartData.pengumuman,
                        backgroundColor: '#D69E2E',
                        borderColor: '#D69E2E',
                        borderWidth: 1,
                        borderRadius: 4
                    },
                    {
                        label: 'Galeri',
                        data: window.barChartData.galeri,
                        backgroundColor: '#805AD5',
                        borderColor: '#805AD5',
                        borderWidth: 1,
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: 'Poppins, sans-serif',
                                size: 12
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                family: 'Poppins, sans-serif',
                                size: 12
                            },
                            stepSize: 1
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                family: 'Poppins, sans-serif',
                                size: 12
                            },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            family: 'Poppins, sans-serif',
                            size: 12
                        },
                        bodyFont: {
                            family: 'Poppins, sans-serif',
                            size: 12
                        },
                        mode: 'index',
                        intersect: false
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            }
        });
        
        // Filter untuk Bar Chart
        const barChartFilter = document.getElementById('barChartFilter');
        if (barChartFilter) {
            barChartFilter.addEventListener('change', function() {
                const filterValue = this.value;
                
                // Data dummy untuk simulasi filter
                let newData = {};
                
                if (filterValue === 'month') {
                    // Data 3 bulan terakhir
                    newData = {
                        labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                        berita: [3, 4, 5, 2],
                        agenda: [2, 3, 4, 1],
                        pengumuman: [1, 2, 3, 1],
                        galeri: [4, 5, 6, 3]
                    };
                } else if (filterValue === 'year') {
                    // Data 12 bulan
                    newData = {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        berita: [15, 18, 22, 20, 25, 30, 28, 32, 35, 30, 28, 25],
                        agenda: [10, 12, 15, 11, 18, 20, 18, 22, 25, 20, 18, 15],
                        pengumuman: [5, 8, 10, 7, 12, 15, 13, 17, 20, 15, 13, 10],
                        galeri: [20, 22, 25, 18, 28, 32, 30, 35, 38, 32, 30, 25]
                    };
                } else {
                    // All - kembali ke data asli
                    newData = {
                        labels: window.barChartData.months,
                        berita: window.barChartData.berita,
                        agenda: window.barChartData.agenda,
                        pengumuman: window.barChartData.pengumuman,
                        galeri: window.barChartData.galeri
                    };
                }
                
                // Update chart data
                barChart.data.labels = newData.labels;
                barChart.data.datasets[0].data = newData.berita;
                barChart.data.datasets[1].data = newData.agenda;
                barChart.data.datasets[2].data = newData.pengumuman;
                barChart.data.datasets[3].data = newData.galeri;
                barChart.update();
            });
        }
    }
    
    // ============ FETCH DATA DINAMIS ============
    function refreshDashboardData() {
        console.log('Refreshing dashboard data...');
        
        // Simulasi fetch data dari server
        fetch('api/get_dashboard_stats.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update stats cards
                    updateStatsCards(data.stats);
                    
                    // Update charts jika diperlukan
                    if (data.charts) {
                        // Di sini bisa update chart data
                        console.log('Chart data updated:', data.charts);
                    }
                    
                    // Show success toast
                    if (typeof showToast === 'function') {
                        showToast('Data dashboard diperbarui', 'success');
                    }
                }
            })
            .catch(error => {
                console.error('Error refreshing data:', error);
            });
    }
    
    function updateStatsCards(stats) {
        // Update each stat card
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach(card => {
            const label = card.querySelector('.stat-label').textContent.toLowerCase();
            const valueElement = card.querySelector('.stat-value');
            
            let newValue = 0;
            
            switch(label) {
                case 'dosen':
                    newValue = stats.jumlah_dosen || 0;
                    break;
                case 'asisten lab':
                    newValue = stats.jumlah_asisten_lab || 0;
                    break;
                case 'magang':
                    newValue = stats.jumlah_magang || 0;
                    break;
                case 'admin':
                    newValue = stats.jumlah_admin || 0;
                    break;
                case 'fasilitas':
                    newValue = stats.jumlah_fasilitas || 0;
                    break;
                case 'produk':
                    newValue = stats.jumlah_produk || 0;
                    break;
                case 'mitra':
                    newValue = stats.jumlah_mitra || 0;
                    break;
                case 'galeri':
                    newValue = stats.jumlah_galeri || 0;
                    break;
            }
            
            // Animate value change
            animateValue(valueElement, parseInt(valueElement.textContent), newValue, 500);
        });
    }
    
    function animateValue(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            element.textContent = Math.floor(progress * (end - start) + start);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }
    
    // Auto refresh every 5 minutes
    setInterval(refreshDashboardData, 5 * 60 * 1000);
    
    // Manual refresh button (optional)
    const refreshBtn = document.createElement('button');
    refreshBtn.innerHTML = '<i class="fas fa-sync-alt"></i>';
    refreshBtn.className = 'refresh-btn';
    refreshBtn.style.position = 'fixed';
    refreshBtn.style.bottom = '20px';
    refreshBtn.style.right = '20px';
    refreshBtn.style.background = 'var(--accent)';
    refreshBtn.style.color = 'white';
    refreshBtn.style.border = 'none';
    refreshBtn.style.borderRadius = '50%';
    refreshBtn.style.width = '50px';
    refreshBtn.style.height = '50px';
    refreshBtn.style.cursor = 'pointer';
    refreshBtn.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
    refreshBtn.style.zIndex = '100';
    refreshBtn.style.display = 'flex';
    refreshBtn.style.alignItems = 'center';
    refreshBtn.style.justifyContent = 'center';
    refreshBtn.style.fontSize = '1.2rem';
    
    refreshBtn.addEventListener('click', function() {
        this.style.transform = 'rotate(360deg)';
        this.style.transition = 'transform 0.5s ease';
        
        refreshDashboardData();
        
        setTimeout(() => {
            this.style.transform = 'rotate(0deg)';
        }, 500);
    });
    
    document.body.appendChild(refreshBtn);
});