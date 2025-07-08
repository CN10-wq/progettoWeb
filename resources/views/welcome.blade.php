{{--  
  pagina di introduzione: con breve presentazione, galleria immagini, faq, servizi, mappa e contatti
--}}
<x-guest-layout>
  <div class="relative h-screen w-full overflow-hidden">
      <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover z-0">
          <source src="{{ asset('storage/video/ny.mp4') }}" type="video/mp4">
      </video>

      <div class="relative z-10 flex flex-col items-center justify-end h-full text-center px-6 pb-10">
          <h1 class="text-4xl md:text-6xl mb-4 drop-shadow-lg leading-tight font-titolo animate-fade-in-up duration-2000">
              Benvenuti al <br>
              <span class="uppercase tracking-wide font-tit font-bold">
                  Back to Beauty Hotel
              </span>
          </h1>

          <p id="slogan" class="text-lg md:text-2xl font-corsivo mb-8 max-w-2xl drop-shadow font-bold"></p>

          <x-a-personalizzato 
              href="{{ route('camere') }}"
              class="px-6 py-3 animate-fade-in-up animation-delay-300 duration-2000">
              Prenota ora
              <x-slot name="span">
                  <span class="ml-2 text-xl inline-block animate-arrow-slide">
                      &rsaquo;
                  </span>
              </x-slot>
          </x-a-personalizzato>
      </div>
  </div>

  <br><br>

  <div class="hidden md:block">
      <section id="intro" class="relative z-10 bg-[#2b2b2b] text-white overflow-hidden py-20 pb-6 w-full px-4 sm:px-10">
          <div class="max-w-full mx-auto">
              <div class="grid md:grid-cols-3 gap-10 items-center relative z-30">
                  <div class="gallery-intro group w-full">
                      <a href="{{ asset('storage/immagini/intro1.jpeg') }}" data-caption="Espressionismo - Colori audaci e tratti intensi" class="block">
                          <div class="relative overflow-hidden rounded-2xl border border-white/10 shadow-lg backdrop-blur-md cursor-zoom-in aspect-square">
                              <img src="{{ asset('storage/immagini/intro1.jpeg') }}" alt="Espressionismo"
                                  class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500" />
                          </div>
                      </a>
                      <div class="mt-2 opacity-0 group-hover:opacity-100 transition duration-500 text-center">
                          <p class="text-sm text-white font-semibold">La Facciata dell’Hotel secondo l’Espressionismo</p>
                          <p class="text-xs text-white/60 italic">Colori audaci e tratti intensi</p>
                      </div>
                  </div>

                  <div class="md:col-span-2 flex flex-col items-end text-right pr-0 sm:pr-4">
                      <h2 class="text-4xl sm:text-5xl lg:text-6xl font-titolo tracking-wide leading-tight">
                          Back to Beauty:<br class="hidden sm:inline"> eleganza, arte, emozione
                      </h2>
                  </div>
              </div>

              <div class="grid md:grid-cols-3 gap-10 items-center relative z-20 md:-translate-y-24">
                  <div class="md:col-span-2 flex items-center justify-center text-center">
                      <p class="text-sm sm:text-base md:text-lg font-corpo text-white/80 leading-relaxed max-w-3xl">
                          Incastonato tra Central Park e la vibrante anima di Manhattan,
                          <span class="text-white">Back to Beauty Hotel</span> è un rifugio dove l’arte non decora — <span class="italic">trasforma</span>.<br>
                          Le nostre camere si scelgono per ispirazione: Espressionismo, Surrealismo, Cubismo.<br>
                          Ogni spazio è un tributo autentico alla creatività contemporanea.
                      </p>
                  </div>

                  <div class="gallery-intro group w-full">
                      <a href="{{ asset('storage/immagini/intro2.jpeg') }}" data-caption="Surrealismo - Visioni oltre la realtà" class="block">
                          <div class="relative overflow-hidden rounded-2xl border border-white/10 shadow-lg backdrop-blur-md cursor-zoom-in aspect-square">
                              <img src="{{ asset('storage/immagini/intro2.jpeg') }}" alt="Surrealismo"
                                  class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500" />
                          </div>
                      </a>
                      <div class="mt-2 opacity-0 group-hover:opacity-100 transition duration-500 text-center">
                          <p class="text-sm text-white font-semibold">La Facciata dell’Hotel secondo il Surrealismo</p>
                          <p class="text-xs text-white/60 italic">Visioni oltre la realtà</p>
                      </div>
                  </div>
              </div>

              <div class="grid md:grid-cols-3 gap-10 items-center relative z-10 md:-translate-y-48">
                  <div class="gallery-intro group w-full">
                      <a href="{{ asset('storage/immagini/intro3.jpeg') }}" data-caption="Cubismo - Volumi e prospettive sovrapposte" class="block">
                          <div class="relative overflow-hidden rounded-2xl border border-white/10 shadow-lg backdrop-blur-md cursor-zoom-in aspect-square">
                              <img src="{{ asset('storage/immagini/intro3.jpeg') }}" alt="Cubismo"
                                  class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500" />
                          </div>
                      </a>
                      <div class="mt-2 opacity-0 group-hover:opacity-100 transition duration-500 text-center">
                          <p class="text-sm text-white font-semibold">La Facciata dell’Hotel secondo il Cubismo</p>
                          <p class="text-xs text-white/60 italic">Volumi e prospettive sovrapposte</p>
                      </div>
                  </div>

                  <div class="md:col-span-2 flex items-center justify-center text-center">
                      <blockquote class="text-white/70 text-xl sm:text-2xl lg:text-3xl font-citazione leading-snug max-w-2xl">
                          “Non si dorme semplicemente in una stanza. Si sogna dentro un’opera.”
                          <br>
                          <span class="text-white/40 text-sm sm:text-base mt-4 block font-corpo">– Back to Beauty</span>
                      </blockquote>
                  </div>
              </div>

          </div>
      </section>
  </div>

  <div class="block md:hidden">
      <section id="intro-mobile" class="bg-[#2b2b2b] text-white py-12 px-4">
          <div class="space-y-10">

              <div class="text-center">
                  <h2 class="text-3xl sm:text-4xl font-titolo leading-tight">
                      Back to Beauty<br><span class="text-white/80">eleganza, arte, emozione</span>
                  </h2>
              </div>

              <div class="gallery-intro group">
                  <a href="{{ asset('storage/immagini/intro1.jpeg') }}" data-caption="Espressionismo - Colori audaci e tratti intensi">
                      <div class="relative overflow-hidden rounded-xl border border-white/10 shadow-md backdrop-blur-md aspect-square cursor-zoom-in">
                          <img src="{{ asset('storage/immagini/intro1.jpeg') }}" alt="Espressionismo"
                              class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500" />
                      </div>
                  </a>
                  <div class="mt-2 text-center">
                      <p class="text-sm font-semibold">La Facciata dell’Hotel secondo l’Espressionismo</p>
                      <p class="text-xs text-white/60 italic">Colori audaci e tratti intensi</p>
                  </div>
              </div>

              <div class="gallery-intro group">
                  <a href="{{ asset('storage/immagini/intro2.jpeg') }}" data-caption="Surrealismo - Visioni oltre la realtà">
                      <div class="relative overflow-hidden rounded-xl border border-white/10 shadow-md backdrop-blur-md aspect-square cursor-zoom-in">
                          <img src="{{ asset('storage/immagini/intro2.jpeg') }}" alt="Surrealismo"
                              class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500" />
                      </div>
                  </a>
                  <div class="mt-2 text-center">
                      <p class="text-sm font-semibold">La Facciata dell’Hotel secondo il Surrealismo</p>
                      <p class="text-xs text-white/60 italic">Visioni oltre la realtà</p>
                  </div>
              </div>

              <div class="gallery-intro group">
                  <a href="{{ asset('storage/immagini/intro3.jpeg') }}" data-caption="Cubismo - Volumi e prospettive sovrapposte">
                      <div class="relative overflow-hidden rounded-xl border border-white/10 shadow-md backdrop-blur-md aspect-square cursor-zoom-in">
                          <img src="{{ asset('storage/immagini/intro3.jpeg') }}" alt="Cubismo"
                              class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500" />
                      </div>
                  </a>
                  <div class="mt-2 text-center">
                      <p class="text-sm font-semibold">La Facciata dell’Hotel secondo il Cubismo</p>
                      <p class="text-xs text-white/60 italic">Volumi e prospettive sovrapposte</p>
                  </div>
              </div>

              <div class="text-center text-sm text-white/80 leading-relaxed font-corpo">
                  Incastonato tra Central Park e la vibrante anima di Manhattan, <span class="text-white">Back to Beauty Hotel</span> è un rifugio dove l’arte non decora — <span class="italic">trasforma</span>.
                  Le nostre camere si scelgono per ispirazione: Espressionismo, Surrealismo, Cubismo. Ogni spazio è un tributo autentico alla creatività contemporanea.
              </div>

              <div class="text-center mt-4">
                  <blockquote class="text-white/70 text-lg leading-snug font-citazione">
                      “Non si dorme semplicemente in una stanza. Si sogna dentro un’opera.”
                      <br>
                      <span class="text-white/40 text-sm font-corpo">– Back to Beauty</span>
                  </blockquote>
              </div>
          </div>
      </section>
  </div>

  <div class="hidden md:block">
      <section class="relative z-30 -mt-32 w-screen overflow-hidden bg-[#2b2b2b] pb-12">
          <h2 class="text-3xl sm:text-5xl lg:text-6xl font-titolo text-center">
              La nostra galleria
          </h2>

          <br><br>

          <div 
              class="carousel js-flickity w-full overflow-visible"
              data-flickity='{
                  "cellAlign": "center",
                  "contain": true,
                  "wrapAround": true,
                  "autoPlay": 4000,
                  "pauseAutoPlayOnHover": true,
                  "pageDots": true,
                  "prevNextButtons": true
              }'
          >
              @foreach (range(4, 9) as $i)
                  <div class="carousel-cell w-full px-3 md:w-[800px] xl:w-[950px]">
                      <div class="rounded-2xl overflow-hidden border border-white/10 shadow-lg backdrop-blur-md transition duration-300">
                          <img 
                              src="{{ asset('storage/immagini/intro' . $i . '.jpeg') }}" 
                              alt="Scorcio hotel {{ $i }}" 
                              class="w-full h-[500px] object-cover"
                          />
                      </div>
                  </div>
              @endforeach
          </div>
      </section>
  </div>

  <div class="block md:hidden">
      <section class="relative z-30 w-screen overflow-hidden bg-[#2b2b2b] pb-10">
          <h2 class="text-2xl sm:text-3xl font-titolo text-center px-4">
              La nostra galleria
          </h2>

          <br>

          <div 
              class="carousel js-flickity w-full px-2"
              data-flickity='{
                  "cellAlign": "center",
                  "contain": true,
                  "wrapAround": true,
                  "autoPlay": 4000,
                  "pauseAutoPlayOnHover": true,
                  "pageDots": true,
                  "prevNextButtons": true
              }'
          >
             @foreach (range(4, 9) as $i)
                <div class="carousel-cell w-full px-3 md:w-[800px] xl:w-[950px]">
                    <div class="rounded-2xl overflow-hidden border border-white/10 shadow-lg backdrop-blur-md transition duration-300">
                        <img 
                            src="{{ asset('storage/immagini/intro' . $i . '.jpeg') }}" 
                            alt="Scorcio hotel {{ $i }}" 
                            class="w-full h-[60vh] md:h-[500px] object-cover"
                        />
                    </div>
                </div>
              @endforeach
          </div>
      </section>
  </div>

  <br><br><br><br>

  <section class="max-w-full mx-auto px-10 py-6">
      <h2 class="text-2xl font-semibold text-white/90 mb-8 border-b border-white/10 pb-2">
          Domande frequenti
      </h2>

      <div class="faq-item border-b border-white/10 py-4">
          <button 
              class="w-full text-left flex justify-between items-center text-white/80 hover:text-white transition" 
              onclick="toggleFaq(this)">
              <span class="text-base sm:text-lg font-medium">
                  Qual è l’orario di check-in e check-out?
              </span>
              <span class="faq-toggle-icon text-2xl font-light transition duration-300">+</span>
          </button>
          <div class="faq-content hidden text-white/60 mt-3 text-sm leading-relaxed">
              Il check-in è disponibile a partire dalle 15:00, mentre il check-out va effettuato entro le 11:00.
          </div>
      </div>

      <div class="faq-item border-b border-white/10 py-4">
          <button 
              class="w-full text-left flex justify-between items-center text-white/80 hover:text-white transition" 
              onclick="toggleFaq(this)">
              <span class="text-base sm:text-lg font-medium">
                  È possibile cancellare gratuitamente una prenotazione?
              </span>
              <span class="faq-toggle-icon text-2xl font-light transition duration-300">+</span>
          </button>
          <div class="faq-content hidden text-white/60 mt-3 text-sm leading-relaxed">
              Offriamo la cancellazione gratuita fino a 24 ore prima del check-in. Dopo tale termine, potrebbe essere applicata una penale. In caso contattare la struttura.
          </div>
      </div>

      <div class="faq-item border-b border-white/10 py-4">
          <button 
              class="w-full text-left flex justify-between items-center text-white/80 hover:text-white transition" 
              onclick="toggleFaq(this)">
              <span class="text-base sm:text-lg font-medium">
                  Quanto dista l’hotel dagli aeroporti principali?
              </span>
              <span class="faq-toggle-icon text-2xl font-light transition duration-300">+</span>
          </button>
          <div class="faq-content hidden text-white/60 mt-3 text-sm leading-relaxed">
              Il nostro hotel si trova a circa 40 minuti in auto dall’aeroporto JFK e 25 minuti da LaGuardia, traffico permettendo. Possiamo organizzare per te transfer privati specificandolo nelle richieste.
          </div>
      </div>

      <div class="faq-item border-b border-white/10 py-4">
          <button 
              class="w-full text-left flex justify-between items-center text-white/80 hover:text-white transition" 
              onclick="toggleFaq(this)">
              <span class="text-base sm:text-lg font-medium">
                  Quali musei consigliate per chi ama Espressionismo, Surrealismo e Cubismo?
              </span>
              <span class="faq-toggle-icon text-2xl font-light transition duration-300">+</span>
          </button>
          <div class="faq-content hidden text-white/60 mt-3 text-sm leading-relaxed">
              Ti consigliamo il MoMA (a 5 minuti a piedi), dove potrai ammirare capolavori di Van Gogh, Dalí, Picasso e Braque.
              Anche il MET e il Whitney Museum offrono collezioni d’arte moderna e avanguardie del ‘900 perfettamente in linea con le nostre ispirazioni.
          </div>
      </div>

      <div class="faq-item border-b border-white/10 py-4">
          <button 
              class="w-full text-left flex justify-between items-center text-white/80 hover:text-white transition" 
              onclick="toggleFaq(this)">
              <span class="text-base sm:text-lg font-medium">
                  Ci sono ristoranti consigliati vicino all’hotel?
              </span>
              <span class="faq-toggle-icon text-2xl font-light transition duration-300">+</span>
          </button>
          <div class="faq-content hidden text-white/60 mt-3 text-sm leading-relaxed">
              Sì, ti suggeriamo <strong>Le Bernardin</strong> per un’esperienza stellata, 
              <strong>Avra Madison</strong> per cucina mediterranea di classe, 
              e <strong>Casa Lever</strong> per chi ama cenare circondato da opere di Warhol. Tutti raggiungibili a piedi.
          </div>
      </div>

      <div class="faq-item border-b border-white/10 py-4">
          <button 
              class="w-full text-left flex justify-between items-center text-white/80 hover:text-white transition" 
              onclick="toggleFaq(this)">
              <span class="text-base sm:text-lg font-medium">
                  Quali negozi e boutique si trovano nelle vicinanze?
              </span>
              <span class="faq-toggle-icon text-2xl font-light transition duration-300">+</span>
          </button>
          <div class="faq-content hidden text-white/60 mt-3 text-sm leading-relaxed">
              Il nostro hotel si trova sulla <strong>Fifth Avenue</strong>, a pochi passi da boutique di alta moda come 
              Chanel, Gucci, Dior, Tiffany & Co. e Apple Store. Un vero paradiso per lo shopping di lusso.
          </div>
      </div>

      <div class="faq-item border-b border-white/10 py-4">
          <button 
              class="w-full text-left flex justify-between items-center text-white/80 hover:text-white transition" 
              onclick="toggleFaq(this)">
              <span class="text-base sm:text-lg font-medium">
                  Posso saperne di più sulle correnti artistiche delle camere?
              </span>
              <span class="faq-toggle-icon text-2xl font-light transition duration-300">+</span>
          </button>
          <div class="faq-content hidden text-white/60 mt-3 text-sm leading-relaxed">
              Ogni camera è ispirata a una corrente artistica: 
              l’<strong>Espressionismo</strong> esalta l’emozione, 
              il <strong>Surrealismo</strong> trasforma il sogno in spazio, 
              il <strong>Cubismo</strong> scompone la realtà in visioni geometriche. 
              Un QR code in stanza ti guida in un viaggio immersivo tra arte e significato.
          </div>
      </div>
  </section>

  <br><br><br>

  <section class="max-w-full mx-auto px-10 py-10 text-white/80">
      <h2 class="text-2xl sm:text-3xl text-white text-center font-semibold mb-12 border-b border-white/10 pb-4">
          I nostri servizi
      </h2>

      <div class="grid sm:grid-cols-2 lg:grid-cols-2 gap-6 max-w-4xl mx-auto text-center text-sm leading-relaxed tracking-wide font-testo">
          <div>
              <span class="text-white block font-medium mb-1">Wi-Fi ultraveloce</span>
              gratuito in tutta la struttura
          </div>
          <div>
              <span class="text-white block font-medium mb-1">Chiave magnetica</span>
              con accesso personalizzato
          </div>
          <div>
              <span class="text-white block font-medium mb-1">Cassaforte digitale</span>
              in ogni camera
          </div>
          <div>
              <span class="text-white block font-medium mb-1">Servizio lavanderia</span>
              con ritiro in camera
          </div>
          <div>
              <span class="text-white block font-medium mb-1">Accesso spa & massaggi</span>
              su prenotazione
          </div>
          <div>
              <span class="text-white block font-medium mb-1">Solo pernottamento</span>
              senza obbligo di colazione
          </div>
          <div>
              <span class="text-white block font-medium mb-1">Chef privato</span>
              per esperienze gastronomiche in camera
          </div>
          <div>
              <span class="text-white block font-medium mb-1">Colazione su misura</span>
              servita in camera
          </div>
          <div>
              <span class="text-white block font-medium mb-1">Parrucchiera & estetista</span>
              disponibili su richiesta
          </div>
          <div>
              <span class="text-white block font-medium mb-1">Autista privato</span>
              con servizio personalizzato
          </div>
      </div>
  </section>

  <br><br><br>

  <section class="max-w-full mx-auto px-10 py-10">
      <h2 class="text-2xl sm:text-3xl text-white text-center font-semibold mb-10 border-b border-white/10 pb-4">
          Come trovarci
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
          <div class="rounded-2xl overflow-hidden border border-white/10 shadow-lg backdrop-blur-md">
              <iframe
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3021.7374889267097!2d-73.97678552410825!3d40.76235953488488!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c258fbd10b7acb%3A0xc74cbeee0f713f59!2s730%205th%20Ave%2C%20New%20York%2C%20NY%2010019%2C%20USA!5e0!3m2!1sit!2sus!4v1719948200000"
                  width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade"
                  class="w-full h-[300px] sm:h-[350px]"
              ></iframe>
          </div>

          <div class="text-white/80 text-sm sm:text-base space-y-5">
              <p>
                  Back to Beauty Hotel ti accoglie al <span class="text-white font-medium">730 5th Avenue, New York</span>, nel cuore elegante di Manhattan. 
                  A pochi passi da Central Park e immerso tra le vetrine iconiche della Fifth Avenue, la nostra dimora d’artista è una destinazione raffinata per chi cerca esclusività, arte e comfort assoluto.
              </p>
              <p>
                  L’accesso è riservato e discreto, con servizio concierge attivo per ogni esigenza. Che tu arrivi con autista, limousine o transfer privato, il nostro staff ti attenderà con cura.
              </p>
              <p>
                  La posizione privilegiata permette di vivere la città con stile: musei, boutique di alta moda, gallerie e teatri sono a pochi minuti dal nostro ingresso.
              </p>
          </div>
      </div>
  </section>
 
  <br>

  <footer class="w-full bg-[#2b2b2b] text-white px-6 sm:px-10 py-10 font-light tracking-wide text-sm md:text-base">
      <div class="w-full space-y-10">

          <div class="border-t border-white/10 w-full"></div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center md:text-left">
              <div>
                  <h2 class="text-sm font-bold uppercase tracking-wide mb-2 font-tit">Hotel Museo</h2>
                  <p class="italic leading-relaxed">
                      The Crown Building<br>
                      730 5th Avenue, Midtown Manhattan<br>
                      New York, NY 10019 – USA
                  </p>
              </div>

              <div>
                  <h2 class="text-sm font-bold uppercase tracking-wide mb-2 font-tit">Contatti</h2>
                  <p class="italic leading-relaxed">
                      Tel: <a href="tel:+11234567890" class="hover:underline">+1 123 456 7890</a><br>
                      Email: <a href="mailto:hotel.museo.ny@gmail.com" class="hover:underline">back.to.beauty.hotel@gmail.com</a>
                  </p>
              </div>

              <div>
                  <h2 class="text-sm font-bold uppercase tracking-wide mb-2 font-tit">Back to Beauty</h2>
                  <p class="font-corsivo text-base md:text-lg leading-relaxed text-white/80">
                      "Un rifugio creativo nel cuore di Manhattan."
                  </p>
              </div>
          </div>

          <div class="border-t border-white/10 w-full"></div>

          <div class="flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0">
              <div class="flex space-x-4 text-lg">
                  <a href="https://facebook.com" target="_blank" class="hover:text-white/60">
                      <i class="fab fa-facebook-f"></i>
                  </a>
                  <a href="https://twitter.com" target="_blank" class="hover:text-white/60">
                      <i class="fab fa-x-twitter"></i>
                  </a>
                  <a href="https://instagram.com" target="_blank" class="hover:text-white/60">
                      <i class="fab fa-instagram"></i>
                  </a>
                  <a href="https://youtube.com" target="_blank" class="hover:text-white/60">
                      <i class="fab fa-youtube"></i>
                  </a>
                  <a href="https://whatsapp.com" target="_blank" class="hover:text-white/60">
                      <i class="fab fa-whatsapp"></i>
                  </a>
              </div>

              <div class="text-white/50 italic text-center md:text-right text-xs">
                  &copy; {{ date('Y') }} Back To Bauty Hotel NYC – Tutti i diritti riservati.
              </div>
          </div>
      </div>
  </footer>

</x-guest-layout>

<button 
    id="scrollToTopBtn" 
    class="fixed bottom-6 right-6 z-50 bg-white/10 hover:bg-white/20 text-white rounded-full p-3 shadow-lg backdrop-blur-md hidden transition-opacity duration-300"
    onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
    aria-label="Torna su"
>
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
    </svg>
</button>








