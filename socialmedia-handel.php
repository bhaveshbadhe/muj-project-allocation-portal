<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creative Team Portfolio</title>
    
    <!-- Favicon -->
    <link rel="icon" href="../muj/photo/muj-title-logo.png" type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
      <style>
        /* Existing styles */
        html {
            scroll-behavior: smooth;
        }
        
        .team-section {
            perspective: 1500px;
        }
        
        .member-card {
            opacity: 0;
            animation: fadeInUp 1.2s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            transition: all 0.5s ease;
        }
        
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .member-card:nth-child(1) { animation-delay: 0.3s; }
        .member-card:nth-child(2) { animation-delay: 0.6s; }
        .member-card:nth-child(3) { animation-delay: 0.9s; }

        /* New hover effects */
        .team-section:hover .member-card:not(:hover) {
            filter: blur(4px) brightness(0.7);
            transform: scale(0.95);
        }

        .member-card:hover {
            transform: translateY(-20px) scale(1.05);
            z-index: 10;
        }

        /* Existing styles continued */
        .social-link {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        
        .social-link:hover {
            transform: translateY(-5px) scale(1.15);
        }
        
        .social-link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: currentColor;
            border-radius: 50%;
            left: 0;
            top: 0;
            opacity: 0;
            transform: scale(1.5);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .social-link:hover::after {
            opacity: 0.15;
            transform: scale(1);
        }

        .member-card img {
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .member-card:hover img {
            transform: scale(1.05);
            filter: brightness(1.1);
        }

        .gradient-text {
            background-size: 200% 200%;
            animation: gradientMove 6s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card-glow {
            position: relative;
            transition: all 0.3s ease;
        }

        .card-glow::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(45deg, #7c3aed, #ec4899, #7c3aed);
            border-radius: inherit;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card-glow:hover::before {
            opacity: 0.5;
        }

        .bg-blur {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-black text-white min-h-screen">
    <!-- Hero Section -->
    <div class="relative h-screen">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900 to-black opacity-90"></div>
        <div class="relative container mx-auto px-4 h-full flex items-center">
            <div class="text-center w-full">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-purple-400 via-pink-500 to-purple-400 gradient-text">Meet Our Team</h1>
                <p class="text-xl text-gray-300 mb-12">Creating digital experiences that matter</p>
                <a href="#team" class="inline-block animate-bounce hover:text-purple-400 transition-colors duration-300">
                    <i class="fas fa-chevron-down text-2xl text-gray-400"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <section id="team" class="py-20 bg-gradient-to-b from-black to-purple-900">
        <div class="container mx-auto px-4">
            <div class="team-section grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <!-- Team Member 1 -->
                <div class="member-card group">
                    <div class="card-glow relative overflow-hidden rounded-2xl bg-gradient-to-br from-purple-800/50 to-black/50 p-1">
                        <div class="bg-black/40 rounded-xl overflow-hidden">
                            <div class="relative overflow-hidden">
                                <img src="../muj/photo/rk2.jpg" alt="Rakesh" class="w-full h-60 object-cover opacity-80 group-hover:opacity-100 transition-all duration-700">
       
                            </div>
                            
                            <div class="p-6">
                                <h3 class="text-2xl font-bold mb-1 text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-500 gradient-text">
                                  Rakesh Mali
                                </h3>
                                <p class="text-purple-300 mb-4">Full Stack Developer</p>
                                
                                <div class="space-y-3 text-sm text-gray-300">
                                    <p class="flex items-center gap-2">
                                        <i class="fas fa-graduation-cap text-purple-400"></i>
                                      B-tech , Information Technology , Manipal University Jaipur
                                    </p>
                                    <p class="flex items-center gap-2">
                                        <i class="fas fa-location-dot text-purple-400"></i>
                                        Rajasthan, Jaipur
                                    </p>
                                </div>

                                <div class="mt-6 flex justify-center space-x-4 pt-4 border-t border-purple-800/30">
                                    <a href="https://www.linkedin.com/in/rakesh-mali-a15082229/" class="social-link text-purple-400 hover:text-purple-300">
                                        <i class="fab fa-linkedin text-xl"></i>
                                    </a>
                                    <a href="https://www.instagram.com/rakesh.mali03/" class="social-link text-purple-400 hover:text-purple-300">
                                        <i class="fab fa-instagram text-xl"></i>
                                    </a>
                                    <a href="mailto:rakeshmali46519@gmail.com" class="social-link text-purple-400 hover:text-purple-300">
                                        <i class="fas fa-envelope text-xl"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="member-card group">
                    <div class="card-glow relative overflow-hidden rounded-2xl bg-gradient-to-br from-purple-800/50 to-black/50 p-1">
                        <div class="bg-black/40 rounded-xl overflow-hidden">
                            <div class="relative overflow-hidden">
                            <img src="../muj/photo/vighnesh.jpg" alt="Vighnesh" class="w-full h-60 object-cover opacity-80 group-hover:opacity-100 transition-all duration-700">
                            </div>
                            
                            <div class="p-6">
                                <h3 class="text-2xl font-bold mb-1 text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-500 gradient-text">
                                 Vighnesh Nikam
                                </h3>
                                <p class="text-purple-300 mb-4">UI/UX Designer</p>
                                
                                <div class="space-y-3 text-sm text-gray-300">
                                    <p class="flex items-center gap-2">
                                        <i class="fas fa-graduation-cap text-purple-400"></i>
                                        B-tech , Information Technology , Manipal University Jaipur
                                    </p>
                                    <p class="flex items-center gap-2">
                                        <i class="fas fa-location-dot text-purple-400"></i>
                                        Rajasthan, Jaipur
                                    </p>
                                </div>

                                <div class="mt-6 flex justify-center space-x-4 pt-4 border-t border-purple-800/30">
                                    <a href="https://www.linkedin.com/in/vighnesh-nikam-162371221/" class="social-link text-purple-400 hover:text-purple-300">
                                        <i class="fab fa-linkedin text-xl"></i>
                                    </a>
                                    <a href="https://www.instagram.com/im.vighnesh/" class="social-link text-purple-400 hover:text-purple-300">
                                        <i class="fab fa-instagram text-xl"></i>
                                    </a>
                                    <a href="mailto:nikamvighnesh7@gmail.com" class="social-link text-purple-400 hover:text-purple-300">
    <i class="fas fa-envelope text-xl"></i>
</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="member-card group">
                    <div class="card-glow relative overflow-hidden rounded-2xl bg-gradient-to-br from-purple-800/50 to-black/50 p-1">
                        <div class="bg-black/40 rounded-xl overflow-hidden">
                            <div class="relative overflow-hidden">
                                <img src="../muj/photo/bhavesh.jpg" alt="Bhavesh" class="w-full h-60 object-cover opacity-80 group-hover:opacity-100 transition-all duration-700">
  
                            </div>
                            
                            <div class="p-6">
                                <h3 class="text-2xl font-bold mb-1 text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-500 gradient-text">
                                   Bhavesh Badhe
                                </h3>
                                <p class="text-purple-300 mb-4"> SQL and Networking</p>
                                
                                <div class="space-y-3 text-sm text-gray-300">
                                    <p class="flex items-center gap-2">
                                        <i class="fas fa-graduation-cap text-purple-400"></i>
                                        B-tech , Information Technology , Manipal University Jaipur
                                    </p>
                                    <p class="flex items-center gap-2">
                                        <i class="fas fa-location-dot text-purple-400"></i>
                                        Rajasthan, Jaipur
                                    </p>
                                </div>

                                <div class="mt-6 flex justify-center space-x-4 pt-4 border-t border-purple-800/30">
                                    <a href="https://www.linkedin.com/in/bhavesh-badhe/" class="social-link text-purple-400 hover:text-purple-300">
                                        <i class="fab fa-linkedin text-xl"></i>
                                    </a>
                                    <a href="https://www.instagram.com/bhaveshhh.21/" class="social-link text-purple-400 hover:text-purple-300">
                                        <i class="fab fa-instagram text-xl"></i>
                                    </a>
                                    <a href="mailto:badhebhavesh0706@gmail.com" class="social-link text-purple-400 hover:text-purple-300">
                                        <i class="fas fa-envelope text-xl"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>