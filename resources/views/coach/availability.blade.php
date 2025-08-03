@extends('layout')
@section('title', 'Coach Dashboard')
@section('content')
    <!-- Disponibilités Coach -->
    <div class="mt-6">
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Mes disponibilités</h2>
            <div class="mb-4 flex gap-4">
                <button id="mode-dispo" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" type="button">Ajouter une disponibilité</button>
                <button id="mode-pause" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="button">Ajouter une pause</button>
                <span id="mode-label" class="ml-4 font-semibold text-gray-700">Mode : <span id="current-mode">Disponibilité</span></span>
            </div>
            <div id="calendar"></div>
            <form method="POST" action="{{ route('updateAvailability', $user->id) }}" id="availability-form">
                @csrf
                <input type="hidden" name="calendar_availabilities" id="calendar_availabilities">
                <button type="submit" class="mt-6 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                    Enregistrer mes disponibilités
                </button>
            </form>
            <div class="mt-6">
                <span class="font-semibold text-gray-800">Créneaux sélectionnés :</span>
                <ul id="slots-list" class="list-disc list-inside mt-2"></ul>
            </div>
            <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
            <script>
                let mode = 'disponibilite';
                // Charger les créneaux enregistrés depuis le backend (JSON)
                let slots = [];
                @if($user->availability)
                    try {
                        slots = JSON.parse(@json($user->availability));
                    } catch (e) { slots = []; }
                @endif

                document.addEventListener('DOMContentLoaded', function() {
                    const calendarEl = document.getElementById('calendar');
                    const slotsList = document.getElementById('slots-list');
                    const modeLabel = document.getElementById('current-mode');
                    document.getElementById('mode-dispo').onclick = function() { mode = 'disponibilite'; modeLabel.textContent = 'Disponibilité'; };
                    document.getElementById('mode-pause').onclick = function() { mode = 'pause'; modeLabel.textContent = 'Pause'; };

                    const calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'timeGridWeek',
                        slotMinTime: '10:00:00',
                        slotMaxTime: '23:00:00',
                        selectable: true,
                        select: function(info) {
                            const slot = {
                                daysOfWeek: [info.start.getDay()],
                                startTime: info.start.toTimeString().slice(0,5),
                                endTime: info.end.toTimeString().slice(0,5),
                                type: mode
                            };
                            slots.push(slot);
                            renderSlots();
                            addSlotEvent(slot);
                        },
                        locale: 'fr',
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'timeGridWeek,timeGridDay'
                        },
                        eventOrder: 'type', // Pour que les pauses soient au-dessus
                    });

                    // Afficher les créneaux déjà enregistrés
                    slots.forEach(slot => {
                        addSlotEvent(slot);
                    });

                    calendar.render();

                    function addSlotEvent(slot) {
                        calendar.addEvent({
                            daysOfWeek: slot.daysOfWeek,
                            startTime: slot.startTime,
                            endTime: slot.endTime,
                            display: 'background',
                            title: slot.type === 'pause' ? 'Pause' : 'Disponible',
                            color: slot.type === 'pause' ? '#fca5a5' : '#a7f3d0',
                            // zIndex pour priorité visuelle
                            zIndex: slot.type === 'pause' ? 99 : 1
                        });
                    }

                    function renderSlots() {
                        slotsList.innerHTML = '';
                        slots.forEach(slot => {
                            const li = document.createElement('li');
                            li.textContent = `${slot.type === 'pause' ? 'Pause' : 'Dispo'} - Jour: ${['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'][slot.daysOfWeek[0]]} de ${slot.startTime} à ${slot.endTime}`;
                            slotsList.appendChild(li);
                        });
                        document.getElementById('calendar_availabilities').value = JSON.stringify(slots);
                    }
                    // Afficher la liste au chargement
                    renderSlots();
                });
            </script>
            @if($availabilities && count($availabilities))
                <div class="mt-6 p-4 bg-gray-100 rounded-lg">
                    <span class="font-semibold text-gray-800">Créneaux enregistrés :</span>
                    <ul class="list-disc list-inside mt-2">
                        @foreach($availabilities as $day => $slots)
                            <li class="text-gray-700 font-medium">{{ $day }}:
                                <span class="font-normal">
                                    @if(isset($slots['start']) && isset($slots['end']))
                                        Début: {{ $slots['start'] }}, Fin: {{ $slots['end'] }}
                                        @if(!empty($slots['break_start']) && !empty($slots['break_end']))
                                            , Pause: {{ $slots['break_start'] }} - {{ $slots['break_end'] }}
                                        @else
                                            , Pas de pause
                                        @endif
                                    @else
                                        Aucun créneau défini
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection
