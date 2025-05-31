<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TouraMaroc</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../../../generalCSS/bootstrap.min.css">
    <link rel="stylesheet" href="../../../generalCSS/style.css">
</head>

<div>
    <?php include '../../components/nav.php' ?>

    <div>
        <section class="hero-section">
            <div class="container">
                <h1 class="display-4 fw-bold mb-4">FAQ</h1>
                <p class="lead">Trouvez les réponses à vos questions sur nos voyages au Maroc</p>
            </div>
        </section>

        <section class="container mb-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">

                    <div class="mb-5">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Rechercher dans la FAQ..." />
                            <button class="btn btn-primary btn-primary-faq" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="faq-category">
                        <h2 class="section-title mb-4">Questions Générales</h2>
                        <div class="accordion" id="generalAccordion">
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#generalOne">
                                        Qu'est-ce qui rend TouraMaroc unique ?
                                    </button>
                                </h3>
                                <div id="generalOne" class="accordion-collapse collapse" data-bs-parent="#generalAccordion">
                                    <div class="accordion-">
                                        <p>TouraMaroc se distingue par son approche authentique et responsable du tourisme. Nous travaillons exclusivement avec des guides locaux, promouvons des hébergements à taille humaine et concevons des expériences qui bénéficient directement aux communautés visitées. Nos circuits évitent les sentiers battus pour vous offrir une vision véritable du Maroc.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#generalTwo">
                                        Quelle est la meilleure période pour visiter le Maroc ?
                                    </button>
                                </h3>
                                <div id="generalTwo" class="accordion-collapse collapse" data-bs-parent="#generalAccordion">
                                    <div class="accordion-">
                                        <p>Le Maroc se visite toute l'année, mais les périodes idéales sont :</p>
                                        <ul>
                                            <li><strong>Printemps (mars-mai)</strong> : Températures agréables et nature en fleurs</li>
                                            <li><strong>Automne (septembre-novembre)</strong> : Climat doux après la chaleur estivale</li>
                                        </ul>
                                        <p>L'été peut être très chaud, surtout dans le désert, tandis que l'hiver est parfait pour le ski dans l'Atlas ou les visites culturelles dans les villes impériales.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#generalThree">
                                        Faut-il un visa pour visiter le Maroc ?
                                    </button>
                                </h3>
                                <div id="generalThree" class="accordion-collapse collapse" data-bs-parent="#generalAccordion">
                                    <div class="accordion-">
                                        <p>Pour la plupart des ressortissants européens, américains et canadiens, aucun visa n'est requis pour des séjours touristiques de moins de 90 jours. Un passeport valide au moins 6 mois après la date d'entrée est suffisant.</p>
                                        <p>Nous vous recommandons de vérifier les exigences spécifiques pour votre nationalité auprès de l'ambassade du Maroc dans votre pays avant le départ.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="faq-category">
                        <h2 class="section-title mb-4">Réservations & Paiements</h2>
                        <div class="accordion" id="bookingAccordion">
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#bookingOne">
                                        Comment puis-je réserver un voyage avec TouraMaroc ?
                                    </button>
                                </h3>
                                <div id="bookingOne" class="accordion-collapse collapse" data-bs-parent="#bookingAccordion">
                                    <div class="accordion-">
                                        <p>Vous pouvez réserver de plusieurs façons :</p>
                                        <ol>
                                            <li>Directement sur notre site web en sélectionnant votre circuit et en suivant le processus de réservation</li>
                                            <li>Par téléphone au +212 6 12 34 56 78 (du lundi au vendredi, 9h-18h)</li>
                                            <li>Par email à contact@touramaroc.com</li>
                                            <li>Via nos partenaires agréés dans votre pays</li>
                                        </ol>
                                        <p>Pour les circuits sur mesure, nous recommandons de nous contacter directement pour discuter de vos besoins spécifiques.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#bookingTwo">
                                        Quelles sont les options de paiement disponibles ?
                                    </button>
                                </h3>
                                <div id="bookingTwo" class="accordion-collapse collapse" data-bs-parent="#bookingAccordion">
                                    <div class="accordion-">
                                        <p>Nous acceptons les modes de paiement suivants :</p>
                                        <ul>
                                            <li>Carte bancaire (Visa, Mastercard) via notre plateforme sécurisée</li>
                                            <li>Virement bancaire</li>
                                            <li>PayPal</li>
                                            <li>Chèque (uniquement pour les résidents marocains)</li>
                                        </ul>
                                        <p>Pour les réservations effectuées plus de 60 jours avant le départ, un acompte de 30% est requis. Le solde est dû 30 jours avant le début du voyage.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#bookingThree">
                                        Quelle est votre politique d'annulation ?
                                    </button>
                                </h3>
                                <div id="bookingThree" class="accordion-collapse collapse" data-bs-parent="#bookingAccordion">
                                    <div class="accordion-">
                                        <p>Notre politique d'annulation est la suivante :</p>
                                        <ul>
                                            <li><strong>Plus de 60 jours avant le départ</strong> : Remboursement intégral moins les frais administratifs (5% du montant total)</li>
                                            <li><strong>Entre 30 et 60 jours avant le départ</strong> : Remboursement de 50%</li>
                                            <li><strong>Moins de 30 jours avant le départ</strong> : Aucun remboursement</li>
                                        </ul>
                                        <p>Nous recommandons vivement de souscrire une assurance voyage couvrant les annulations pour des raisons médicales ou autres circonstances imprévues.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="faq-category">
                        <h2 class="section-title mb-4">Préparation au Voyage</h2>
                        <div class="accordion" id="prepAccordion">
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#prepOne">
                                        Que dois-je emporter pour mon voyage au Maroc ?
                                    </button>
                                </h3>
                                <div id="prepOne" class="accordion-collapse collapse" data-bs-parent="#prepAccordion">
                                    <div class="accordion-">
                                        <p>Notre liste d'essentiels comprend :</p>
                                        <ul>
                                            <li><strong>Vêtements</strong> : Adaptés à la saison, avec des options modestes pour visiter les lieux religieux</li>
                                            <li><strong>Chaussures</strong> : Confortables pour la marche, surtout dans les médinas</li>
                                            <li><strong>Santé</strong> : Crème solaire, médicaments personnels, petite trousse de premiers soins</li>
                                            <li><strong>Documents</strong> : Passeport, copies numériques, assurance voyage</li>
                                            <li><strong>Divers</strong> : Adaptateur de prise (type C/E), appareil photo, lingettes humides</li>
                                        </ul>
                                        <p>Pour les circuits spécifiques (désert, montagne), nous fournissons une liste d'équipement détaillée après réservation.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#prepTwo">
                                        Le Maroc est-il un pays sûr pour les voyageurs ?
                                    </button>
                                </h3>
                                <div id="prepTwo" class="accordion-collapse collapse" data-bs-parent="#prepAccordion">
                                    <div class="accordion-">
                                        <p>Le Maroc est généralement considéré comme une destination sûre pour les touristes. Cependant, comme partout :</p>
                                        <ul>
                                            <li>Gardez vos objets de valeur en sécurité</li>
                                            <li>Évitez de montrer des signes ostentatoires de richesse</li>
                                            <li>Soyez prudent dans les endroits très fréquentés</li>
                                            <li>Respectez les coutumes locales</li>
                                        </ul>
                                        <p>Nos guides sont formés pour assurer votre sécurité tout au long du voyage. Nous surveillons également en permanence la situation dans toutes nos destinations.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#prepThree">
                                        Quelle est la politique vestimentaire recommandée ?
                                    </button>
                                </h3>
                                <div id="prepThree" class="accordion-collapse collapse" data-bs-parent="#prepAccordion">
                                    <div class="accordion-">
                                        <p>Le Maroc étant un pays majoritairement musulman, nous recommandons :</p>
                                        <ul>
                                            <li><strong>Femmes</strong> : Évitez les décolletés profonds et les shorts/jupes très courts. Dans les zones rurales, des vêtements couvrant les épaules et les genoux sont préférables.</li>
                                            <li><strong>Hommes</strong> : Évitez les torse nu en ville et les shorts très courts.</li>
                                        </ul>
                                        <p>Sur les plages et dans les hôtels, les tenues occidentales standards sont acceptées. Pour visiter les mosquées (sauf la Hassan II à Casablanca), les non-musulmans ne sont généralement pas admis.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="contact-box">
                        <div class="contact-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h3>Vous ne trouvez pas la réponse à votre question ?</h3>
                        <p class="mb-4">Notre équipe est à votre disposition pour toute information complémentaire.</p>
                        <a href="contact.html" class="btn btn-primary btn-primary-faq">Contactez-nous</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php include '../../components/footer.php' ?>

</div>