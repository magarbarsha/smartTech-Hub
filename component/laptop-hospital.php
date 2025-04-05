<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laptop Hospital - SmartTech Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #0056b3;
            --accent-color: #4fc3f7;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --gray-color: #6c757d;
            --white: #ffffff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            color: var(--dark-color);
            line-height: 1.6;
            padding-top: 0;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 20px;
        }

        /* Header Styles */
        .header {
            text-align: center;
            margin-bottom: 2rem;
            padding: 2rem;
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: var(--shadow);
            border-top: 5px solid var(--primary-color);
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 1rem;
        }

        .logo i {
            font-size: 2.5rem;
            color: var(--primary-color);
        }

        .logo h1 {
            font-size: 2.2rem;
            color: var(--dark-color);
        }

        .tagline {
            color: var(--gray-color);
            font-size: 1.1rem;
            margin-top: 0.5rem;
        }

        /* Step Styles */
        .step {
            display: none;
            background-color: var(--white);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary-color);
        }

        .step.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        .step h2 {
            margin-bottom: 1.5rem;
            color: var(--primary-color);
            text-align: center;
            font-size: 1.8rem;
            position: relative;
            padding-bottom: 10px;
        }

        .step h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--primary-color);
        }

        /* Options Grid */
        .options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .option-card {
            background-color: var(--white);
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #e9ecef;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .option-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-color);
        }

        .option-card.selected {
            border-color: var(--primary-color);
            background-color: rgba(0, 123, 255, 0.05);
        }

        .option-card .icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            background-color: rgba(0, 123, 255, 0.1);
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .option-card h3 {
            margin-bottom: 0.75rem;
            color: var(--dark-color);
            font-size: 1.2rem;
        }

        .option-card p {
            color: var(--gray-color);
            font-size: 0.9rem;
        }

        /* Symptoms List */
        .symptoms-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .symptom-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9ecef;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .symptom-item:hover {
            border-color: var(--primary-color);
            transform: translateX(5px);
        }

        .symptom-item input {
            margin-right: 1rem;
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: var(--primary-color);
        }

        .symptom-item label {
            flex: 1;
            cursor: pointer;
            font-size: 0.95rem;
        }

        /* Button Styles */
        .btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn:disabled {
            background-color: #adb5bd;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn.secondary {
            background-color: var(--white);
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .btn.secondary:hover {
            background-color: #f0f7ff;
        }

        /* Results Container */
        .results-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .diagnosis-card, .solution-card {
            background-color: var(--white);
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        .diagnosis-card h3, .solution-card h3 {
            margin-bottom: 1rem;
            color: var(--primary-color);
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .diagnosis-card h3 i, .solution-card h3 i {
            color: var(--primary-color);
        }

        .confidence-meter {
            margin-top: 1.5rem;
        }

        .confidence-bar {
            height: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .confidence-fill {
            height: 100%;
            width: 85%;
            background: linear-gradient(90deg, var(--success-color), #5cb85c);
            border-radius: 5px;
            transition: width 0.5s ease;
        }

        .solution-text {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            line-height: 1.6;
            color: var(--dark-color);
        }

        .solution-details {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 5px;
            border-left: 4px solid var(--primary-color);
            font-size: 0.95rem;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
            gap: 1rem;
        }

        /* Repair Options */
        .repair-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .repair-card {
            background-color: var(--white);
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            border-top: 4px solid var(--primary-color);
            transition: transform 0.3s ease;
        }

        .repair-card:hover {
            transform: translateY(-5px);
        }

        .repair-card h3 {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
            font-size: 1.3rem;
        }

        .repair-card p {
            margin-bottom: 1.5rem;
            color: var(--gray-color);
            line-height: 1.5;
        }

        .pros-cons {
            list-style: none;
            margin: 1rem 0;
            flex-grow: 1;
        }

        .pros-cons li {
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
        }

        .fa-check-circle {
            color: var(--success-color);
        }

        .fa-times-circle {
            color: var(--danger-color);
        }

        .repair-select {
            align-self: flex-start;
            margin-top: auto;
        }

        /* Navigation */
        .navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            padding: 1rem 0;
            border-top: 1px solid #e9ecef;
        }

        .step-indicator {
            display: flex;
            gap: 0.75rem;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #e9ecef;
            transition: background-color 0.3s ease;
        }

        .dot.active {
            background-color: var(--primary-color);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow-y: auto;
        }

        .modal-content {
            background-color: var(--white);
            margin: 5% auto;
            padding: 2rem;
            border-radius: 10px;
            width: 80%;
            max-width: 800px;
            position: relative;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
            border-top: 5px solid var(--primary-color);
        }

        .close-modal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--gray-color);
            transition: color 0.3s;
        }

        .close-modal:hover {
            color: var(--danger-color);
        }

        .guide-content {
            margin: 1.5rem 0;
        }

        .guide-content h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        .guide-content ol {
            padding-left: 1.5rem;
            margin: 1rem 0;
        }

        .guide-content li {
            margin-bottom: 0.75rem;
            line-height: 1.6;
        }

        .tools-needed, .time-estimate {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #e9ecef;
        }

        .tools-needed h3, .time-estimate h3 {
            color: var(--primary-color);
            margin-bottom: 0.75rem;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tools-needed ul {
            list-style: none;
        }

        .tools-needed li {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tools-needed li::before {
            content: "•";
            color: var(--primary-color);
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }

        /* Safety Notice */
        .safety-notice {
            background-color: #fff3cd;
            color: #856404;
            padding: 1rem;
            border-radius: 5px;
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-left: 4px solid #ffeeba;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .container {
                padding: 0 15px;
            }
            
            .header {
                padding: 1.5rem;
            }
            
            .step {
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .options-grid {
                grid-template-columns: 1fr;
            }
            
            .repair-options {
                grid-template-columns: 1fr;
            }
            
            .modal-content {
                width: 90%;
                padding: 1.5rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
            
            .step h2 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .header {
                padding: 1rem;
            }
            
            .logo h1 {
                font-size: 1.8rem;
            }
            
            .logo i {
                font-size: 2rem;
            }
            
            .step {
                padding: 1rem;
            }
            
            .modal-content {
                width: 95%;
                margin: 2% auto;
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    
    <div class="container">
        <header class="header">
            <div class="logo">
                <i class="fas fa-laptop-medical"></i>
                <h1>Laptop Hospital</h1>
            </div>
            <p class="tagline">Diagnose and fix your laptop problems with our expert system</p>
        </header>

        <main class="diagnostic-flow">
            <!-- Step 1: Problem Selection -->
            <div class="step active" id="step1">
                <h2>What type of problem are you experiencing?</h2>
                <div class="options-grid">
                    <div class="option-card" data-problem="performance">
                        <div class="icon"><i class="fas fa-tachometer-alt"></i></div>
                        <h3>Performance Issues</h3>
                        <p>Slow boot, lagging, freezing</p>
                    </div>
                    <div class="option-card" data-problem="battery">
                        <div class="icon"><i class="fas fa-battery-quarter"></i></div>
                        <h3>Battery Problems</h3>
                        <p>Short battery life, not charging</p>
                    </div>
                    <div class="option-card" data-problem="hardware">
                        <div class="icon"><i class="fas fa-microchip"></i></div>
                        <h3>Hardware Issues</h3>
                        <p>Keyboard, screen, ports not working</p>
                    </div>
                    <div class="option-card" data-problem="software">
                        <div class="icon"><i class="fas fa-bug"></i></div>
                        <h3>Software Problems</h3>
                        <p>Crashes, errors, OS issues</p>
                    </div>
                    <div class="option-card" data-problem="heating">
                        <div class="icon"><i class="fas fa-temperature-high"></i></div>
                        <h3>Overheating</h3>
                        <p>Fan noise, too hot to touch</p>
                    </div>
                    <div class="option-card" data-problem="network">
                        <div class="icon"><i class="fas fa-wifi"></i></div>
                        <h3>Network Issues</h3>
                        <p>WiFi problems, slow internet</p>
                    </div>
                </div>
            </div>

            <!-- Step 2: Specific Symptoms -->
            <div class="step" id="step2">
                <h2>Select all symptoms you're experiencing</h2>
                <div class="symptoms-list" id="symptoms-list">
                    <!-- Dynamically populated by JavaScript -->
                </div>
                <button class="btn" id="analyze-btn" disabled>Analyze Symptoms</button>
            </div>

            <!-- Step 3: Diagnosis Results -->
            <div class="step" id="step3">
                <h2>Diagnosis Results</h2>
                <div class="results-container">
                    <div class="diagnosis-card">
                        <h3><i class="fas fa-diagnoses"></i> Most Likely Issue</h3>
                        <p id="primary-diagnosis">Loading...</p>
                        <div class="confidence-meter">
                            <div class="confidence-bar">
                                <div class="confidence-fill" id="confidence-fill"></div>
                            </div>
                            <span id="confidence-value">85% confidence</span>
                        </div>
                    </div>
                    
                    <div class="solution-card">
                        <h3><i class="fas fa-lightbulb"></i> Recommended Solution</h3>
                        <div id="solution-content">
                            <p class="solution-text">Loading solution...</p>
                            <div class="solution-details" id="solution-details"></div>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button class="btn secondary" id="back-to-symptoms">
                            <i class="fas fa-arrow-left"></i> Re-analyze
                        </button>
                        <button class="btn" id="next-steps-btn">
                            Next Steps <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 4: Repair Options -->
            <div class="step" id="step4">
                <h2>Repair Options</h2>
                <div class="repair-options">
                    <div class="repair-card" data-difficulty="easy">
                        <h3><i class="fas fa-wrench"></i> DIY Fix</h3>
                        <p>Step-by-step guide to fix it yourself with common tools and basic technical knowledge.</p>
                        <ul class="pros-cons">
                            <li><i class="fas fa-check-circle"></i> Least expensive option</li>
                            <li><i class="fas fa-check-circle"></i> Immediate solution</li>
                            <li><i class="fas fa-times-circle"></i> Requires some technical skill</li>
                            <li><i class="fas fa-times-circle"></i> No professional warranty</li>
                        </ul>
                        <button class="btn repair-select" data-option="diy">View Guide</button>
                    </div>
                    
                    <div class="repair-card" data-difficulty="medium">
                        <h3><i class="fas fa-store"></i> Local Repair Shop</h3>
                        <p>Find certified technicians near you who can professionally handle the repair.</p>
                        <ul class="pros-cons">
                            <li><i class="fas fa-check-circle"></i> Professional service</li>
                            <li><i class="fas fa-check-circle"></i> Warranty on repairs</li>
                            <li><i class="fas fa-times-circle"></i> More expensive than DIY</li>
                            <li><i class="fas fa-check-circle"></i> Faster than manufacturer service</li>
                        </ul>
                        <button class="btn repair-select" data-option="local">Find Shops</button>
                    </div>
                    
                    <div class="repair-card" data-difficulty="hard">
                        <h3><i class="fas fa-box-open"></i> Manufacturer Service</h3>
                        <p>Official repair from the laptop maker using genuine parts and technicians.</p>
                        <ul class="pros-cons">
                            <li><i class="fas fa-check-circle"></i> Highest quality parts</li>
                            <li><i class="fas fa-check-circle"></i> Preserves warranty</li>
                            <li><i class="fas fa-times-circle"></i> Most expensive option</li>
                            <li><i class="fas fa-times-circle"></i> May take longer</li>
                        </ul>
                        <button class="btn repair-select" data-option="manufacturer">Contact Manufacturer</button>
                    </div>
                </div>
            </div>
        </main>

        <div class="navigation">
            <button class="btn back-btn" disabled id="back-btn">
                <i class="fas fa-arrow-left"></i> Back
            </button>
            <div class="step-indicator">
                <span class="dot active"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
        </div>
    </div>

    <!-- DIY Repair Modal -->
    <div class="modal" id="diy-modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2><i class="fas fa-wrench"></i> DIY Repair Guide</h2>
            <div class="guide-content" id="diy-guide-content">
                <!-- Filled by JavaScript -->
            </div>
            <div class="tools-needed">
                <h3><i class="fas fa-tools"></i> Tools Needed</h3>
                <ul id="tools-list">
                    <!-- Filled by JavaScript -->
                </ul>
            </div>
            <div class="time-estimate">
                <h3><i class="fas fa-clock"></i> Time Estimate: <span id="repair-time">20-30 minutes</span></h3>
            </div>
        </div>
    </div>
           
    <?php include 'footer.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM Elements
            const steps = document.querySelectorAll('.step');
            const optionCards = document.querySelectorAll('.option-card');
            const symptomsList = document.getElementById('symptoms-list');
            const analyzeBtn = document.getElementById('analyze-btn');
            const backBtn = document.getElementById('back-btn');
            const nextStepsBtn = document.getElementById('next-steps-btn');
            const backToSymptomsBtn = document.getElementById('back-to-symptoms');
            const stepIndicators = document.querySelectorAll('.step-indicator .dot');
            const diyModal = document.getElementById('diy-modal');
            const closeModal = document.querySelector('.close-modal');
            const repairSelectBtns = document.querySelectorAll('.repair-select');
            
            // State variables
            let currentStep = 0;
            let selectedProblem = null;
            let selectedSymptoms = [];
            
            // Problem database
            const problemsDB = {
                performance: {
                    name: "Performance Issues",
                    symptoms: [
                        { id: "slow_boot", text: "Slow boot up time" },
                        { id: "lagging", text: "General lagging/slowness" },
                        { id: "freezing", text: "System freezes or crashes" },
                        { id: "slow_apps", text: "Applications open slowly" },
                        { id: "multitask_slow", text: "Can't multitask effectively" }
                    ],
                    diagnoses: [
                        {
                            id: "hdd_issue",
                            name: "Aging Hard Drive",
                            description: "Your laptop is using a traditional hard disk drive (HDD) which significantly slows down performance.",
                            solution: "Upgrade to an SSD (Solid State Drive)",
                            confidence: 85,
                            details: "Traditional HDDs are much slower than SSDs. Upgrading to an SSD can improve boot times by 300% and make applications launch instantly.",
                            repair: {
                                diy: {
                                    steps: [
                                        "Back up all your important data",
                                        "Purchase a compatible SSD (check your laptop's specifications)",
                                        "Use cloning software to copy your existing drive to the new SSD",
                                        "Physically install the SSD (usually requires opening the bottom panel)",
                                        "Boot from the new SSD and verify everything works"
                                    ],
                                    tools: ["Screwdriver set", "External hard drive enclosure (for cloning)", "SSD drive"],
                                    time: "1-2 hours"
                                },
                                local: "Most computer repair shops can perform an SSD upgrade for $50-100 plus the cost of the SSD.",
                                manufacturer: "Some manufacturers offer SSD upgrade services, but they tend to be more expensive."
                            }
                        },
                        {
                            id: "low_ram",
                            name: "Insufficient RAM",
                            description: "Your laptop doesn't have enough memory for modern applications.",
                            solution: "Upgrade your RAM",
                            confidence: 75,
                            details: "With only 4GB of RAM, your laptop struggles with modern applications. Upgrading to 8GB or 16GB will allow for smooth multitasking.",
                            repair: {
                                diy: {
                                    steps: [
                                        "Determine the type and maximum amount of RAM your laptop supports",
                                        "Purchase compatible RAM modules",
                                        "Power off the laptop and remove the battery if possible",
                                        "Open the RAM access panel (location varies by model)",
                                        "Remove old RAM and insert new modules at a 45-degree angle",
                                        "Press down until they click into place",
                                        "Replace the cover and power on to verify"
                                    ],
                                    tools: ["Small screwdriver", "Anti-static wrist strap (recommended)", "New RAM modules"],
                                    time: "20-30 minutes"
                                },
                                local: "RAM upgrades typically cost $30-50 for labor plus the cost of RAM.",
                                manufacturer: "Manufacturer RAM upgrades are often 2-3x more expensive than aftermarket options."
                            }
                        },
                        {
                            id: "malware",
                            name: "Malware Infection",
                            description: "Your system may be infected with malware slowing it down.",
                            solution: "Run a malware scan and clean your system",
                            confidence: 65,
                            details: "Malware can consume system resources in the background. A thorough scan and cleanup can restore performance.",
                            repair: {
                                diy: {
                                    steps: [
                                        "Download and install a reputable antivirus program if you don't have one",
                                        "Update the antivirus definitions",
                                        "Run a full system scan",
                                        "Quarantine and remove any detected threats",
                                        "Consider using specialized malware removal tools like Malwarebytes",
                                        "Reset your browser settings if you're experiencing browser-related issues"
                                    ],
                                    tools: ["Antivirus software", "Malware removal tools"],
                                    time: "1-3 hours depending on scan speed"
                                },
                                local: "Most repair shops offer malware removal services for $50-100.",
                                manufacturer: "Manufacturers typically don't offer malware removal services."
                            }
                        }
                    ]
                },
                battery: {
                    name: "Battery Problems",
                    symptoms: [
                        { id: "short_life", text: "Battery drains quickly" },
                        { id: "not_charging", text: "Won't charge when plugged in" },
                        { id: "swollen", text: "Battery appears swollen" },
                        { id: "random_shutdown", text: "Laptop shuts down unexpectedly" },
                        { id: "wrong_percentage", text: "Battery percentage is inaccurate" }
                    ],
                    diagnoses: [
                        {
                            id: "old_battery",
                            name: "Worn Out Battery",
                            description: "Your battery has degraded from normal use and needs replacement.",
                            solution: "Replace the battery",
                            confidence: 90,
                            details: "Lithium-ion batteries typically last 2-4 years. If your battery lasts less than an hour or won't hold a charge, it needs replacement.",
                            repair: {
                                diy: {
                                    steps: [
                                        "Purchase a compatible replacement battery",
                                        "Power off the laptop and unplug it",
                                        "Remove the bottom panel or battery compartment cover",
                                        "Disconnect the old battery (may require removing screws)",
                                        "Connect the new battery and reassemble",
                                        "Fully charge before first use"
                                    ],
                                    tools: ["Screwdriver set", "Replacement battery"],
                                    time: "15-30 minutes"
                                },
                                local: "Battery replacement typically costs $20-50 for labor plus the battery cost.",
                                manufacturer: "Manufacturer batteries are more expensive but often higher quality."
                            }
                        },
                        {
                            id: "charging_issue",
                            name: "Charging Circuit Problem",
                            description: "There may be an issue with your laptop's charging circuit or power adapter.",
                            solution: "Diagnose charging hardware",
                            confidence: 70,
                            details: "If the battery isn't charging, the problem could be with the power adapter, charging port, or internal charging circuit.",
                            repair: {
                                diy: {
                                    steps: [
                                        "Try a different power adapter if available",
                                        "Inspect the charging port for damage",
                                        "Check if the charging LED lights up when connected",
                                        "Reset the battery by removing it (if possible) and holding the power button for 30 seconds",
                                        "If none of these work, professional diagnosis may be needed"
                                    ],
                                    tools: ["Multimeter (for advanced diagnosis)", "Alternative power adapter"],
                                    time: "15-30 minutes"
                                },
                                local: "Charging port repairs typically cost $50-150 depending on the issue.",
                                manufacturer: "Manufacturer repair centers can diagnose charging issues but may be more expensive."
                            }
                        }
                    ]
                }
            };
            
            // Initialize the app
            init();
            
            function init() {
                // Set up event listeners
                optionCards.forEach(card => {
                    card.addEventListener('click', selectProblemCategory);
                });
                
                analyzeBtn.addEventListener('click', analyzeSymptoms);
                backBtn.addEventListener('click', goToPreviousStep);
                nextStepsBtn.addEventListener('click', goToNextStep);
                backToSymptomsBtn.addEventListener('click', goToSymptomsStep);
                closeModal.addEventListener('click', () => diyModal.style.display = "none");
                repairSelectBtns.forEach(btn => {
                    btn.addEventListener('click', showRepairGuide);
                });
                
                // Close modal when clicking outside
                window.addEventListener('click', (e) => {
                    if (e.target === diyModal) {
                        diyModal.style.display = "none";
                    }
                });
            }
            
            function selectProblemCategory(e) {
                const card = e.currentTarget;
                selectedProblem = card.getAttribute('data-problem');
                
                // Highlight selected card
                optionCards.forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                
                // Populate symptoms list
                populateSymptomsList();
                
                // Move to next step
                goToNextStep();
            }
            
            function populateSymptomsList() {
                symptomsList.innerHTML = '';
                
                problemsDB[selectedProblem].symptoms.forEach(symptom => {
                    const symptomItem = document.createElement('div');
                    symptomItem.className = 'symptom-item';
                    symptomItem.innerHTML = `
                        <input type="checkbox" id="${symptom.id}" name="symptoms">
                        <label for="${symptom.id}">${symptom.text}</label>
                    `;
                    symptomsList.appendChild(symptomItem);
                    
                    // Add event listener to checkboxes
                    const checkbox = symptomItem.querySelector('input');
                    checkbox.addEventListener('change', updateSelectedSymptoms);
                });
            }
            
            function updateSelectedSymptoms() {
                const checkboxes = document.querySelectorAll('input[name="symptoms"]:checked');
                selectedSymptoms = Array.from(checkboxes).map(cb => cb.id);
                
                // Enable/disable analyze button
                analyzeBtn.disabled = selectedSymptoms.length === 0;
            }
            
            function analyzeSymptoms() {
                // In a real app, this would use more sophisticated analysis
                // For demo, we'll just pick the first diagnosis
                
                const diagnosis = problemsDB[selectedProblem].diagnoses[0];
                displayDiagnosis(diagnosis);
                goToNextStep();
            }
            
            function displayDiagnosis(diagnosis) {
                document.getElementById('primary-diagnosis').textContent = diagnosis.name + ": " + diagnosis.description;
                document.querySelector('.solution-text').textContent = diagnosis.solution;
                document.getElementById('solution-details').textContent = diagnosis.details;
                
                // Update confidence meter
                const confidenceFill = document.getElementById('confidence-fill');
                confidenceFill.style.width = diagnosis.confidence + '%';
                document.getElementById('confidence-value').textContent = diagnosis.confidence + '% confidence';
                
                // Store diagnosis for repair options
                nextStepsBtn.dataset.diagnosisId = diagnosis.id;
            }
            
            function showRepairGuide(e) {
                const option = e.currentTarget.getAttribute('data-option');
                const diagnosisId = nextStepsBtn.dataset.diagnosisId;
                
                // Find the diagnosis
                const diagnosis = problemsDB[selectedProblem].diagnoses.find(d => d.id === diagnosisId);
                
                if (diagnosis && diagnosis.repair[option]) {
                    const guideContent = document.getElementById('diy-guide-content');
                    const toolsList = document.getElementById('tools-list');
                    
                    if (option === 'diy') {
                        // Show DIY guide
                        guideContent.innerHTML = `
                            <h3>Step-by-Step Instructions:</h3>
                            <ol>
                                ${diagnosis.repair.diy.steps.map(step => `<li>${step}</li>`).join('')}
                            </ol>
                        `;
                        
                        toolsList.innerHTML = diagnosis.repair.diy.tools.map(tool => `<li>${tool}</li>`).join('');
                        document.getElementById('repair-time').textContent = diagnosis.repair.diy.time;
                    } else {
                        // Show service options
                        guideContent.innerHTML = `
                            <h3>Service Information:</h3>
                            <p>${diagnosis.repair[option]}</p>
                            <div class="notice">
                                <i class="fas fa-info-circle"></i> This is a simulated recommendation. In a real application, 
                                this would connect to actual service providers or manufacturer support.
                            </div>
                        `;
                        
                        toolsList.innerHTML = '<li>None required - professional service</li>';
                        document.getElementById('repair-time').textContent = "Varies by provider";
                    }
                    
                    diyModal.style.display = "block";
                }
            }
            
            function goToNextStep() {
                if (currentStep < steps.length - 1) {
                    steps[currentStep].classList.remove('active');
                    currentStep++;
                    steps[currentStep].classList.add('active');
                    updateStepIndicator();
                    updateBackButton();
                }
            }
            
            function goToPreviousStep() {
                if (currentStep > 0) {
                    steps[currentStep].classList.remove('active');
                    currentStep--;
                    steps[currentStep].classList.add('active');
                    updateStepIndicator();
                    updateBackButton();
                }
            }
            
            function goToSymptomsStep() {
                steps[currentStep].classList.remove('active');
                currentStep = 1;
                steps[currentStep].classList.add('active');
                updateStepIndicator();
                updateBackButton();
            }
            
            function updateStepIndicator() {
                stepIndicators.forEach((dot, index) => {
                    if (index <= currentStep) {
                        dot.classList.add('active');
                    } else {
                        dot.classList.remove('active');
                    }
                });
            }
            
            function updateBackButton() {
                backBtn.disabled = currentStep === 0;
            }
        });
    </script>
</body>
</html>