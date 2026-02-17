<x-layout>

    <main class="container">
        <section class="row wh-75 justify-content-center mt-3">
            <h3 class="text-center">
                    <strong>Lavora con noi</strong>
                </h3>

                <h4 class="text-center">
                    Siamo una grande squadra.</h4>
                   <p class="text-center"> Vogliamo apportare un cambiamento positivo nel mondo aiutando tutti a vendere e comprare, ogni giorno.
                </p>

            {{-- LEFT SIDE - VANTAGGI --}}
            <article class="col-12 col-md-5 me-5 mt-5 sidebar-register">

                <h5 class="text-center mb-4 p-2">
                    <strong>I vantaggi del Team di Subito</strong>
                </h5>

                <div class="sidebar-item d-flex align-items-start mb-3">
                    <div class="me-3 sidebar-icon">
                        <img src="{{ asset('media/register/casa.png') }}" alt="Icon" >
                    </div>
                    <div>
                        <p class="mb-1"><strong>Smartworking</strong></p>
                        <p class="small text-muted mb-0 mx-1">
                            Ci piace essere smart e poter scegliere il posto migliore da cui connetterci e lavorare!
                        </p>
                    </div>
                </div>

                <div class="sidebar-item d-flex align-items-start mb-3">
                    <div class="me-3 sidebar-icon">
                        <img src="{{ asset('media/register/orologio.png') }}" alt="Icon">
                    </div>
                    <div>
                        <p class="mb-1"><strong>Flessibilità oraria</strong></p>
                        <p class="small text-muted mb-0 mx-1">
                            Il worklife balance è importante per noi! Offriamo a tutti una flessibilità oraria che possa andare incontro alle nostre esigenze di tutti i giorni.
                        </p>
                    </div>
                </div>

                <div class="sidebar-item d-flex align-items-start mb-3">
                    <div class="me-3 sidebar-icon">
                        <img src="{{ asset('media/register/smile.png') }}" alt="Icon">
                    </div>
                    <div>
                        <p class="mb-1"><strong>Bonus “Presenta un Amico”</strong></p>
                        <p class="small text-muted mb-0 mx-1">
                            Crediamo nel valore dell’amicizia, presentaci un tuo amico e riceverai un premio.
                        </p>
                    </div>
                </div>

                <div class="sidebar-item d-flex align-items-start">
                    <div class="me-3 sidebar-icon">
                        <img src="{{ asset('media/register/stella.png') }}" alt="Icon">
                    </div>
                    <div>
                        <p class="mb-1"><strong>Welcome on board</strong></p>
                        <p class="small text-muted mb-0 mx-1">
                            Siamo un Team in continua espansione! Quando arriva un nuovo collega lo accompagniamo nell’avvio delle nuove attività.
                        </p>
                    </div>
                </div>

            </article>


            {{-- RIGHT SIDE - FORM --}}
            <article class="col-12 col-md-5 mt-5 registerSection">

                <form method="POST" action="#" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Messaggio</label>
                        <textarea rows="4" class="form-control textForm" name="message" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Carica il tuo CV</label>
                        <input type="file"
                               class="form-control shadow"
                               name="cv"
                               accept=".pdf,.doc,.docx"
                               required>
                    </div>

                    <div class="col-auto box-buttons">
                        <button type="submit" class="mb-3 form-button w-50 mt-3">
                            Invia
                        </button>
                    </div>

                </form>

            </article>

        </section>
    </main>

</x-layout>
