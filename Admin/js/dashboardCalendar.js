// dashboardCalendar.js - Handle Calendar & Agenda Interactions

document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard Calendar JS loaded');
    
    // ============ FULLCALENDAR INITIALIZATION ============
    const calendarEl = document.getElementById('calendar');
    if (calendarEl && FullCalendar) {
        // Inisialisasi kalender
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            events: window.calendarEvents || [],
            headerToolbar: {
                left: 'title',
                center: '',
                right: 'prev,next today'
            },
            buttonText: {
                today: 'Hari Ini'
            },
            height: 'auto',
            firstDay: 1, // Senin
            dayMaxEvents: 3,
            eventDisplay: 'block',
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            dayHeaderContent: function(args) {
                // Format header hari (Singkatan bahasa Indonesia)
                const days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
                return days[args.date.getDay()];
            },
            eventClick: function(info) {
                showEventDetails(info.event);
            },
            dateClick: function(info) {
                // When date is clicked, show add event modal
                showAddEventModal(info.dateStr);
            }
        });
        
        calendar.render();
        window.calendarInstance = calendar; // Simpan instance untuk diakses nanti
        
        // ============ CALENDAR NAVIGATION ============
        const prevMonthBtn = document.getElementById('prevMonth');
        const nextMonthBtn = document.getElementById('nextMonth');
        
        if (prevMonthBtn) {
            prevMonthBtn.addEventListener('click', function() {
                calendar.prev();
            });
        }
        
        if (nextMonthBtn) {
            nextMonthBtn.addEventListener('click', function() {
                calendar.next();
            });
        }
        
        // ============ AGENDA ITEM INTERACTIONS ============
        const agendaItems = document.querySelectorAll('.agenda-item:not(.empty-agenda)');
        agendaItems.forEach(item => {
            // Click on agenda item
            item.addEventListener('click', function(e) {
                if (!e.target.closest('.agenda-actions')) {
                    const agendaId = this.getAttribute('data-id');
                    const agendaDate = this.getAttribute('data-date');
                    
                    // Navigate to that date in calendar
                    calendar.gotoDate(agendaDate);
                    
                    // Highlight the event
                    highlightCalendarEvent(agendaId);
                    
                    // Show details
                    showAgendaDetails(this);
                }
            });
            
            // Edit button
            const editBtn = this.querySelector('.btn-edit-agenda');
            if (editBtn) {
                editBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const agendaId = item.getAttribute('data-id');
                    editAgenda(agendaId);
                });
            }
            
            // Delete button
            const deleteBtn = this.querySelector('.btn-delete-agenda');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const agendaId = item.getAttribute('data-id');
                    const agendaTitle = item.querySelector('.agenda-title').textContent;
                    deleteAgenda(agendaId, agendaTitle);
                });
            }
        });
        
        // ============ ADD NEW AGENDA BUTTON ============
        const addAgendaBtn = document.querySelector('.btn-add-agenda');
        if (addAgendaBtn) {
            addAgendaBtn.addEventListener('click', function(e) {
                e.preventDefault();
                showAddEventModal();
            });
        }
    }
    
    // ============ HELPER FUNCTIONS ============
    function highlightCalendarEvent(eventId) {
        const calendar = window.calendarInstance;
        if (calendar) {
            const event = calendar.getEventById(eventId);
            if (event) {
                // Flash the event
                const originalColor = event.backgroundColor;
                event.setProp('backgroundColor', '#F6AD55');
                
                setTimeout(() => {
                    event.setProp('backgroundColor', originalColor);
                }, 2000);
            }
        }
    }
    
    function showAgendaDetails(agendaItem) {
        const title = agendaItem.querySelector('.agenda-title').textContent;
        const date = agendaItem.querySelector('.agenda-day').textContent + ' ' + 
                    agendaItem.querySelector('.agenda-month').textContent;
        const time = agendaItem.querySelector('.agenda-time').textContent;
        
        // Create modal
        const modal = document.createElement('div');
        modal.className = 'agenda-detail-modal';
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Detail Agenda</h3>
                    <button class="modal-close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="detail-item">
                        <strong>Judul:</strong>
                        <p>${title}</p>
                    </div>
                    <div class="detail-item">
                        <strong>Tanggal:</strong>
                        <p>${date}</p>
                    </div>
                    <div class="detail-item">
                        <strong>Waktu:</strong>
                        <p>${time}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-edit">Edit</button>
                    <button class="btn-close">Tutup</button>
                </div>
            </div>
        `;
        
        // Add styles
        modal.style.position = 'fixed';
        modal.style.top = '0';
        modal.style.left = '0';
        modal.style.right = '0';
        modal.style.bottom = '0';
        modal.style.background = 'rgba(0,0,0,0.5)';
        modal.style.display = 'flex';
        modal.style.alignItems = 'center';
        modal.style.justifyContent = 'center';
        modal.style.zIndex = '9999';
        
        const modalContent = modal.querySelector('.modal-content');
        modalContent.style.background = 'white';
        modalContent.style.borderRadius = '12px';
        modalContent.style.padding = '25px';
        modalContent.style.maxWidth = '500px';
        modalContent.style.width = '90%';
        modalContent.style.boxShadow = '0 10px 30px rgba(0,0,0,0.2)';
        
        document.body.appendChild(modal);
        
        // Close handlers
        const closeBtn = modal.querySelector('.modal-close');
        const closeBtn2 = modal.querySelector('.btn-close');
        
        closeBtn.addEventListener('click', () => modal.remove());
        closeBtn2.addEventListener('click', () => modal.remove());
        
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.remove();
        });
        
        // Edit button
        const editBtn = modal.querySelector('.btn-edit');
        editBtn.addEventListener('click', () => {
            const agendaId = agendaItem.getAttribute('data-id');
            modal.remove();
            editAgenda(agendaId);
        });
    }
    
    function editAgenda(agendaId) {
        // In real app, redirect to edit page
        window.location.href = `agenda/edit.php?id=${agendaId}`;
    }
    
    function deleteAgenda(agendaId, agendaTitle) {
        if (confirm(`Apakah Anda yakin ingin menghapus agenda "${agendaTitle}"?`)) {
            // In real app, send DELETE request
            console.log('Deleting agenda:', agendaId);
            
            // Remove from DOM
            const agendaItem = document.querySelector(`.agenda-item[data-id="${agendaId}"]`);
            if (agendaItem) {
                agendaItem.style.opacity = '0.5';
                
                // Simulate API call
                setTimeout(() => {
                    agendaItem.remove();
                    
                    // Check if agenda list is empty
                    const agendaList = document.querySelector('.agenda-list');
                    if (agendaList.children.length === 0) {
                        agendaList.innerHTML = `
                            <div class="agenda-item empty-agenda">
                                <div class="agenda-content">
                                    <div class="agenda-title">
                                        <i class="fas fa-calendar-times"></i> Tidak ada agenda mendatang
                                    </div>
                                    <div class="agenda-description">
                                        <small>Tambahkan agenda baru untuk mengisi kalender</small>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    
                    // Show success message
                    if (typeof showToast === 'function') {
                        showToast('Agenda berhasil dihapus', 'success');
                    }
                }, 500);
            }
        }
    }
    
    function showAddEventModal(date = null) {
        // Create modal for adding event
        const modal = document.createElement('div');
        modal.className = 'add-event-modal';
        
        const today = date ? new Date(date) : new Date();
        const formattedDate = today.toISOString().split('T')[0];
        
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Tambah Agenda Baru</h3>
                    <button class="modal-close">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="addEventForm">
                        <div class="form-group">
                            <label>Judul Agenda</label>
                            <input type="text" id="eventTitle" required placeholder="Masukkan judul agenda">
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" id="eventDate" value="${formattedDate}" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Waktu Mulai</label>
                                <input type="time" id="eventStartTime" value="09:00" required>
                            </div>
                            <div class="form-group">
                                <label>Waktu Selesai</label>
                                <input type="time" id="eventEndTime" value="10:00" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi (Opsional)</label>
                            <textarea id="eventDescription" rows="3" placeholder="Tambahkan deskripsi agenda"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="addEventForm" class="btn-save">Simpan</button>
                    <button class="btn-cancel">Batal</button>
                </div>
            </div>
        `;
        
        // Add styles
        modal.style.position = 'fixed';
        modal.style.top = '0';
        modal.style.left = '0';
        modal.style.right = '0';
        modal.style.bottom = '0';
        modal.style.background = 'rgba(0,0,0,0.5)';
        modal.style.display = 'flex';
        modal.style.alignItems = 'center';
        modal.style.justifyContent = 'center';
        modal.style.zIndex = '9999';
        
        const modalContent = modal.querySelector('.modal-content');
        modalContent.style.background = 'white';
        modalContent.style.borderRadius = '12px';
        modalContent.style.padding = '25px';
        modalContent.style.maxWidth = '500px';
        modalContent.style.width = '90%';
        modalContent.style.boxShadow = '0 10px 30px rgba(0,0,0,0.2)';
        
        document.body.appendChild(modal);
        
        // Close handlers
        const closeBtn = modal.querySelector('.modal-close');
        const cancelBtn = modal.querySelector('.btn-cancel');
        
        closeBtn.addEventListener('click', () => modal.remove());
        cancelBtn.addEventListener('click', () => modal.remove());
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.remove();
        });
        
        // Form submission
        const form = modal.querySelector('#addEventForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const title = document.getElementById('eventTitle').value;
            const date = document.getElementById('eventDate').value;
            const startTime = document.getElementById('eventStartTime').value;
            const endTime = document.getElementById('eventEndTime').value;
            
            // Validate time
            if (startTime >= endTime) {
                alert('Waktu selesai harus setelah waktu mulai');
                return;
            }
            
            // Simulate saving
            console.log('Saving event:', { title, date, startTime, endTime });
            
            // Show success message
            if (typeof showToast === 'function') {
                showToast('Agenda berhasil ditambahkan', 'success');
            }
            
            // Close modal
            modal.remove();
            
            // Reload page or update UI
            setTimeout(() => {
                window.location.reload(); // or update agenda list dynamically
            }, 1000);
        });
    }
    
    // ============ SYNC CALENDAR WITH AGENDA ============
    function syncCalendarWithAgenda() {
        const calendar = window.calendarInstance;
        if (!calendar) return;
        
        // Get all agenda items
        const agendaItems = document.querySelectorAll('.agenda-item:not(.empty-agenda)');
        
        // Create events array
        const events = [];
        agendaItems.forEach(item => {
            const id = item.getAttribute('data-id');
            const title = item.querySelector('.agenda-title').textContent;
            const date = item.getAttribute('data-date');
            const startTime = item.getAttribute('data-start');
            const endTime = item.getAttribute('data-end');
            
            events.push({
                id: id,
                title: title,
                start: `${date}T${startTime}`,
                end: `${date}T${endTime}`,
                color: '#3182CE',
                allDay: false
            });
        });
        
        // Update calendar events
        calendar.removeAllEvents();
        calendar.addEventSource(events);
    }
    
    // ============ TODAY'S DATE HIGHLIGHT ============
    function highlightToday() {
        const today = new Date();
        const todayStr = today.toISOString().split('T')[0];
        
        // Highlight today in calendar
        const todayCell = document.querySelector(`.fc-day[data-date="${todayStr}"]`);
        if (todayCell) {
            todayCell.style.backgroundColor = 'rgba(49, 130, 206, 0.1)';
            todayCell.style.border = '2px solid var(--accent)';
        }
    }
    
    // Call after calendar is rendered
    setTimeout(highlightToday, 1000);
    
    // Export functions
    window.syncCalendarWithAgenda = syncCalendarWithAgenda;
});