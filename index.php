<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ReAi - AI Developer Assistant</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            sidebar: '#0a0e27',
            primary: '#6366f1',
            secondary: '#8b5cf6',
            accent: '#ec4899'
          }
        }
      }
    }
  </script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
    
    * { 
      margin: 0; 
      padding: 0; 
      box-sizing: border-box; 
    }
    
    html, body {
      height: 100%;
      overflow: hidden;
    }
    
    body { 
      font-family: 'Plus Jakarta Sans', sans-serif; 
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    /* Scrollbar Custom */
    .scrollbar-custom::-webkit-scrollbar { width: 6px; height: 6px; }
    .scrollbar-custom::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); }
    .scrollbar-custom::-webkit-scrollbar-thumb { 
      background: linear-gradient(180deg, #6366f1 0%, #8b5cf6 100%);
      border-radius: 10px; 
    }
    .scrollbar-custom::-webkit-scrollbar-thumb:hover { background: #8b5cf6; }
    
    /* Glassmorphism */
    .glass {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    /* Animasi */
    @keyframes slideIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.5; }
    }
    
    @keyframes gradient {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    
    @keyframes blink {
      0%, 100% { opacity: 0.2; }
      50% { opacity: 1; }
    }
    
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
    
    .message { animation: slideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
    
    .animated-gradient {
      background: linear-gradient(270deg, #6366f1, #8b5cf6, #ec4899);
      background-size: 600% 600%;
      animation: gradient 3s ease infinite;
    }
    
    /* Code Block Modern */
    .code-block {
      position: relative;
      margin: 20px 0;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      border: 1px solid rgba(99, 102, 241, 0.2);
    }
    
    .code-header {
      background: linear-gradient(135deg, #1a1f3a 0%, #2d1b4e 100%);
      padding: 12px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid rgba(99, 102, 241, 0.3);
    }
    
    .code-lang {
      color: #a5b4fc;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .code-lang::before {
      content: '';
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
      animation: pulse 2s infinite;
    }
    
    .code-actions {
      display: flex;
      gap: 8px;
    }
    
    .code-btn {
      background: rgba(99, 102, 241, 0.1);
      color: #c7d2fe;
      border: 1px solid rgba(99, 102, 241, 0.3);
      padding: 6px 14px;
      border-radius: 8px;
      font-size: 11px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      align-items: center;
      gap: 6px;
    }
    
    .code-btn:hover {
      background: rgba(99, 102, 241, 0.2);
      border-color: rgba(99, 102, 241, 0.5);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }
    
    .code-btn.active {
      background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
      border-color: #6366f1;
      color: white;
    }
    
    .code-content {
      background: #0f1419;
      position: relative;
    }
    
    .code-content pre {
      margin: 0;
      padding: 20px;
      overflow-x: auto;
      font-family: 'Fira Code', 'Courier New', monospace;
    }
    
    .code-content code {
      color: #e6edf3;
      font-size: 13px;
      line-height: 1.8;
    }
    
    .preview-container {
      background: white;
      padding: 20px;
      min-height: 400px;
    }
    
    .preview-frame {
      width: 100%;
      height: 500px;
      border: none;
      border-radius: 8px;
      background: white;
    }
    
    /* Sidebar Item */
    .sidebar-item {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }
    
    .sidebar-item::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 3px;
      background: linear-gradient(180deg, #6366f1 0%, #8b5cf6 100%);
      transform: scaleY(0);
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .sidebar-item:hover::before,
    .sidebar-item.active::before {
      transform: scaleY(1);
    }
    
    .sidebar-item:hover {
      background: rgba(99, 102, 241, 0.1);
      padding-left: 16px;
    }
    
    .sidebar-item.active {
      background: rgba(99, 102, 241, 0.15);
      padding-left: 16px;
    }
    
    /* Typing Animation */
    .typing-indicator {
      display: flex;
      align-items: center;
      gap: 4px;
      padding: 8px 0;
    }
    
    .typing-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
      animation: blink 1.4s infinite;
    }
    
    .typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .typing-dot:nth-child(3) { animation-delay: 0.4s; }
    
    /* Logo Animation */
    .logo-icon {
      animation: pulse 2s infinite;
    }
    
    /* Input Focus Effect */
    .input-focus {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .input-focus:focus {
      box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1), 0 8px 24px rgba(99, 102, 241, 0.2);
      transform: translateY(-2px);
    }
    
    /* New Floating Animation */
    .floating {
      animation: float 6s ease-in-out infinite;
    }
    
    /* Improved Welcome Screen */
    .welcome-card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      transition: all 0.3s ease;
    }
    
    .welcome-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }
    
    /* Improved Message Bubbles */
    .user-message {
      background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
      box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
    }
    
    .ai-message {
      background: white;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }
    
    /* Improved Sidebar */
    .sidebar {
      background: linear-gradient(180deg, #0a0e27 0%, #1a1f3a 100%);
    }
    
    /* Improved Header */
    .header {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
    }
    
    /* Improved Input Area */
    .input-area {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
    }
    
    /* Improved Select */
    .model-select {
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(10px);
      transition: all 0.3s ease;
    }
    
    .model-select:hover {
      background: white;
      box-shadow: 0 5px 15px rgba(99, 102, 241, 0.2);
    }

    /* ===== FIXED LAYOUT STYLES ===== */
    
    /* Main container fixes */
    .app-container {
      display: flex;
      width: 100%;
      height: 100vh;
      overflow: hidden;
      position: fixed;
      top: 0;
      left: 0;
    }
    
    .sidebar {
      width: 320px;
      flex-shrink: 0;
      height: 100%;
      overflow-y: auto;
      z-index: 10;
    }
    
    .main-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      height: 100%;
      min-width: 0;
      position: relative;
    }
    
    .chat-container {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 0;
    }
    
    #chat {
      flex: 1;
      overflow-y: auto;
      min-height: 0;
      padding-top: 0 !important;
    }
    
    .input-area {
      flex-shrink: 0;
    }
    
    .header {
      flex-shrink: 0;
      z-index: 20;
      position: relative;
    }
    
    /* Welcome screen fixes */
    .welcome-screen {
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      position: relative;
      z-index: 1;
    }
    
    .welcome-content {
      max-width: 800px;
      width: 100%;
      text-align: center;
      margin-top: -40px;
    }
    
    .welcome-grid {
      margin-top: 2rem;
    }
    
    /* Mobile Styles */
    @media (max-width: 768px) {
      .app-container {
        position: fixed;
        width: 100%;
        height: 100%;
      }
      
      .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 50;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
      }
      
      .sidebar.active {
        transform: translateX(0);
      }
      
      .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 40;
        display: none;
      }
      
      .sidebar-overlay.active {
        display: block;
      }
      
      .mobile-menu-btn {
        display: flex !important;
        position: fixed;
        top: 16px;
        left: 16px;
        z-index: 60;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        width: 48px;
        height: 48px;
        border-radius: 12px;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      }
      
      .mobile-close-btn {
        display: flex !important;
        position: absolute;
        top: 16px;
        right: 16px;
        z-index: 51;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        width: 48px;
        height: 48px;
        border-radius: 12px;
        align-items: center;
        justify-content: center;
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
      }
      
      .header {
        padding: 12px 16px;
        padding-top: 70px;
      }
      
      .header-content {
        flex-direction: column;
        gap: 12px;
        align-items: flex-start;
      }
      
      .model-select {
        width: 100%;
        max-width: 100%;
      }
      
      .chat-title-container {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }
      
      .chat-title {
        font-size: 14px;
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
      }
      
      #chat {
        padding: 16px;
        padding-top: 0;
      }
      
      .welcome-screen {
        padding: 16px;
        padding-top: 0;
      }
      
      .welcome-content {
        margin-top: -20px;
      }
      
      .message {
        gap: 12px;
      }
      
      .message .w-12 {
        width: 40px;
        height: 40px;
      }
      
      .user-message, .ai-message {
        padding: 12px 16px;
        border-radius: 18px;
        max-width: 85%;
      }
      
      .input-area {
        padding: 16px;
      }
      
      .input-form {
        flex-direction: column;
        gap: 12px;
      }
      
      #message-input {
        padding: 14px 16px;
        font-size: 16px;
      }
      
      #send-btn {
        width: 100%;
        height: 48px;
        border-radius: 16px;
      }
      
      .code-block {
        margin: 12px 0;
        border-radius: 12px;
      }
      
      .code-header {
        padding: 10px 16px;
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
      }
      
      .code-actions {
        width: 100%;
        justify-content: space-between;
      }
      
      .code-btn {
        flex: 1;
        justify-content: center;
        padding: 8px 12px;
      }
      
      .code-content pre {
        padding: 16px;
      }
      
      .preview-container {
        padding: 16px;
      }
      
      .preview-frame {
        height: 300px;
      }
      
      .welcome-grid {
        grid-template-columns: 1fr !important;
        gap: 12px;
      }
      
      .welcome-card {
        padding: 16px;
      }
    }
    
    /* Tablet Styles */
    @media (min-width: 769px) and (max-width: 1024px) {
      .sidebar {
        width: 280px;
      }
      
      .message {
        max-width: 90%;
      }
      
      .code-btn {
        padding: 6px 10px;
        font-size: 10px;
      }
      
      .welcome-content {
        margin-top: -30px;
      }
    }
    
    /* Desktop Styles */
    @media (min-width: 1025px) {
      .welcome-content {
        margin-top: -50px;
      }
    }
    
    /* Hide mobile elements on desktop */
    @media (min-width: 769px) {
      .mobile-menu-btn, .mobile-close-btn, .sidebar-overlay {
        display: none !important;
      }
      
      .header {
        padding-top: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="app-container">
    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <!-- Sidebar -->
    <div class="sidebar text-white flex flex-col h-full shadow-2xl">
      <!-- Mobile Close Button -->
      <button class="mobile-close-btn" id="mobile-close-btn">
        <i class="fas fa-times text-xl"></i>
      </button>
      
      <!-- Logo Header -->
      <div class="p-6 border-b border-white border-opacity-10">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-2xl flex items-center justify-center animated-gradient logo-icon floating">
            <i class="fas fa-bolt text-white text-xl"></i>
          </div>
          <div>
            <h1 class="text-2xl font-black tracking-tight">
              <span class="bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">ReAi</span>
            </h1>
            <p class="text-xs text-gray-400 font-medium">Developer Assistant</p>
          </div>
        </div>
      </div>

      <!-- New Chat Button -->
      <button id="new-chat-btn" class="m-4 px-5 py-3.5 animated-gradient hover:shadow-2xl rounded-xl flex items-center justify-center gap-3 transition-all duration-300 font-bold text-sm hover:scale-105 shadow-lg">
        <i class="fas fa-plus-circle"></i>
        <span>Percakapan Baru</span>
      </button>

      <!-- History Section -->
      <div class="px-4 pb-3 pt-2">
        <div class="flex items-center gap-2 text-xs text-gray-400 uppercase tracking-wider font-bold">
          <i class="fas fa-history"></i>
          <span>Riwayat Chat</span>
        </div>
      </div>
      
      <div id="history-list" class="flex-1 overflow-y-auto scrollbar-custom px-3 space-y-2"></div>
      
      <!-- Footer Info -->
      <div class="p-4 border-t border-white border-opacity-10">
        <div class="glass rounded-xl p-3">
          <div class="flex items-center justify-between text-xs">
            <div class="flex items-center gap-2 text-gray-300">
              <i class="fas fa-info-circle"></i>
              <span class="font-semibold">ReAi v2.5</span>
            </div>
            <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Chat Area -->
    <div class="main-content flex flex-col bg-gray-50">
      <!-- Mobile Menu Button -->
      <button class="mobile-menu-btn" id="mobile-menu-btn">
        <i class="fas fa-bars text-indigo-600 text-lg"></i>
      </button>
      
      <!-- Header -->
      <div class="header border-b border-gray-100">
        <div class="max-w-6xl mx-auto p-5 header-content">
          <div class="flex items-center gap-4 w-full">
            <select id="model-select" class="model-select text-sm font-semibold border-2 border-gray-200 rounded-xl px-4 py-2.5 hover:border-indigo-400 focus:border-indigo-500 focus:outline-none transition-all cursor-pointer">
              <option value="meta-llama/llama-4-maverick-17b-128e-instruct">🦙 Llama 4 Maverick</option>
              <option value="moonshotai/kimi-k2-instruct-0905">🌙 Kimi K2 Instruct</option>
            </select>
          </div>
          <div class="chat-title-container">
            <div class="text-sm font-bold text-gray-800 chat-title" id="current-chat-title">Percakapan Baru</div>
            <button id="delete-chat-btn" class="text-red-500 hover:bg-red-50 w-9 h-9 rounded-xl flex items-center justify-center transition-all hover:scale-110" title="Hapus Chat">
              <i class="fas fa-trash-alt"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Chat Container -->
      <div class="chat-container flex-1">
        <!-- Chat Messages -->
        <div id="chat" class="overflow-y-auto scrollbar-custom p-6 space-y-6 bg-gradient-to-b from-gray-50 to-white"></div>

        <!-- Input Area -->
        <div class="input-area border-t border-gray-100 shadow-lg">
          <form id="chat-form" class="max-w-5xl mx-auto p-6 input-form">
            <div class="flex gap-3">
              <input
                type="text"
                id="message-input"
                placeholder="Tanya apa saja tentang coding... (contoh: Buatkan landing page modern)"
                class="flex-1 px-6 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:border-indigo-500 input-focus transition-all text-sm font-medium bg-gray-50 focus:bg-white"
                autocomplete="off"
                required
              />
              <button
                type="submit"
                id="send-btn"
                class="animated-gradient text-white w-16 h-16 rounded-2xl flex items-center justify-center transition-all hover:scale-110 shadow-lg hover:shadow-2xl"
                aria-label="Kirim"
              >
                <i class="fas fa-paper-plane text-lg"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    // === UTILITIES ===
    function escapeHtml(text) {
      const div = document.createElement('div');
      div.textContent = text;
      return div.innerHTML;
    }

    // === CODE DETECTION ===
    function detectCodeBlocks(text) {
      const blocks = [];
      
      // Markdown code blocks
      const markdownRegex = /```(\w*)\s*\n([\s\S]*?)\n```/g;
      let match;
      while ((match = markdownRegex.exec(text)) !== null) {
        blocks.push({
          start: match.index,
          end: match.index + match[0].length,
          language: match[1] || 'plaintext',
          code: match[2],
          type: 'markdown'
        });
      }
      
      // Full HTML documents
      const htmlFullRegex = /(<!DOCTYPE[\s\S]*?<\/html>|<html[\s\S]*?<\/html>)/gi;
      while ((match = htmlFullRegex.exec(text)) !== null) {
        const overlaps = blocks.some(b => 
          (match.index >= b.start && match.index < b.end) ||
          (match.index + match[0].length > b.start && match.index + match[0].length <= b.end)
        );
        if (!overlaps) {
          blocks.push({
            start: match.index,
            end: match.index + match[0].length,
            language: 'html',
            code: match[0],
            type: 'auto'
          });
        }
      }
      
      return blocks.sort((a, b) => a.start - b.start);
    }

    function createCodeBlock(code, language) {
      const safeCode = escapeHtml(code.trim());
      const blockId = 'code-' + Math.random().toString(36).substr(2, 9);
      const canPreview = language === 'html';
      
      const languageIcons = {
        html: 'fa-brands fa-html5',
        css: 'fa-brands fa-css3-alt',
        javascript: 'fa-brands fa-js',
        python: 'fa-brands fa-python',
        php: 'fa-brands fa-php',
        default: 'fa-code'
      };
      
      const icon = languageIcons[language.toLowerCase()] || languageIcons.default;
      
      const rawForAttr = code.trim()
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');

      return `
        <div class="code-block" data-block-id="${blockId}">
          <div class="code-header">
            <span class="code-lang">
              <i class="${icon}"></i>
              ${language}
            </span>
            <div class="code-actions">
              ${canPreview ? `<button class="code-btn preview-btn" data-block="${blockId}">
                <i class="fas fa-eye"></i> Preview
              </button>` : ''}
              <button class="code-btn copy-btn" data-code="${rawForAttr}">
                <i class="fas fa-copy"></i> Salin Kode
              </button>
            </div>
          </div>
          <div class="code-content" data-view="code">
            <pre><code>${safeCode}</code></pre>
          </div>
          ${canPreview ? `<div class="preview-container" data-view="preview" style="display:none;">
            <iframe class="preview-frame" sandbox="allow-scripts allow-same-origin"></iframe>
          </div>` : ''}
        </div>
      `;
    }

    function formatAIResponse(text) {
      const codeBlocks = detectCodeBlocks(text);
      
      if (codeBlocks.length === 0) {
        let formatted = escapeHtml(text);
        formatted = formatted.replace(/\*\*(.*?)\*\*/g, '<strong class="font-bold text-indigo-900">$1</strong>');
        formatted = formatted.replace(/\n\n/g, '</p><p class="mt-4">');
        formatted = formatted.replace(/\n/g, '<br>');
        return '<div class="prose prose-sm max-w-none"><p class="text-gray-700 leading-relaxed">' + formatted + '</p></div>';
      }

      let result = '';
      let lastIndex = 0;
      
      codeBlocks.forEach(block => {
        const textBefore = text.substring(lastIndex, block.start).trim();
        if (textBefore) {
          let formatted = escapeHtml(textBefore);
          formatted = formatted.replace(/\*\*(.*?)\*\*/g, '<strong class="font-bold text-indigo-900">$1</strong>');
          formatted = formatted.replace(/\n\n/g, '</p><p class="mt-4">');
          formatted = formatted.replace(/\n/g, '<br>');
          result += '<div class="prose prose-sm max-w-none mb-4"><p class="text-gray-700 leading-relaxed">' + formatted + '</p></div>';
        }
        
        result += createCodeBlock(block.code, block.language);
        lastIndex = block.end;
      });
      
      const textAfter = text.substring(lastIndex).trim();
      if (textAfter) {
        let formatted = escapeHtml(textAfter);
        formatted = formatted.replace(/\*\*(.*?)\*\*/g, '<strong class="font-bold text-indigo-900">$1</strong>');
        formatted = formatted.replace(/\n\n/g, '</p><p class="mt-4">');
        formatted = formatted.replace(/\n/g, '<br>');
        result += '<div class="prose prose-sm max-w-none mt-4"><p class="text-gray-700 leading-relaxed">' + formatted + '</p></div>';
      }
      
      return result;
    }

    function attachCodeBlockListeners() {
      document.querySelectorAll('.copy-btn').forEach(btn => {
        btn.onclick = (e) => {
          e.stopPropagation();
          const code = btn.getAttribute('data-code');
          if (!code) return;
          navigator.clipboard.writeText(code).then(() => {
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i> Tersalin!';
            btn.classList.add('active');
            setTimeout(() => {
              btn.innerHTML = orig;
              btn.classList.remove('active');
            }, 2000);
          }).catch(err => {
            console.error('Gagal menyalin:', err);
          });
        };
      });

      document.querySelectorAll('.preview-btn').forEach(btn => {
        btn.onclick = (e) => {
          e.stopPropagation();
          const blockId = btn.getAttribute('data-block');
          const block = document.querySelector(`[data-block-id="${blockId}"]`);
          const codeView = block.querySelector('[data-view="code"]');
          const previewView = block.querySelector('[data-view="preview"]');
          const iframe = previewView.querySelector('iframe');

          if (codeView.style.display !== 'none') {
            const copyBtn = block.querySelector('.copy-btn');
            const code = copyBtn ? copyBtn.getAttribute('data-code') : '';
            if (code) {
              iframe.srcdoc = code;
            }
            codeView.style.display = 'none';
            previewView.style.display = 'block';
            btn.innerHTML = '<i class="fas fa-code"></i> Lihat Kode';
            btn.classList.add('active');
          } else {
            codeView.style.display = 'block';
            previewView.style.display = 'none';
            btn.innerHTML = '<i class="fas fa-eye"></i> Preview';
            btn.classList.remove('active');
          }
        };
      });
    }

    // === STATE MANAGEMENT ===
    let allChats = [];
    let currentChatId = null;

    try {
      const stored = localStorage.getItem('reaiAllChats');
      if (stored) allChats = JSON.parse(stored);
      currentChatId = localStorage.getItem('reaiCurrentChatId');
    } catch (e) {
      console.error('Error loading chats:', e);
    }

    function saveChats() {
      try {
        localStorage.setItem('reaiAllChats', JSON.stringify(allChats));
        localStorage.setItem('reaiCurrentChatId', currentChatId);
      } catch (e) {
        console.error('Error saving chats:', e);
      }
    }

    function getCurrentChat() {
      return allChats.find(c => c.id === currentChatId) || null;
    }

    function createNewChat() {
      const newId = 'chat-' + Date.now();
      allChats.unshift({ 
        id: newId, 
        title: 'Percakapan Baru', 
        messages: [],
        created: new Date().toISOString()
      });
      currentChatId = newId;
      saveChats();
      renderHistory();
      renderChat();
      document.getElementById('current-chat-title').textContent = 'Percakapan Baru';
      closeSidebar();
    }

    function deleteCurrentChat() {
      if (!currentChatId) return;
      if (!confirm('Hapus percakapan ini?')) return;
      
      allChats = allChats.filter(c => c.id !== currentChatId);
      saveChats();
      
      if (allChats.length > 0) {
        currentChatId = allChats[0].id;
        saveChats();
        renderHistory();
        renderChat();
        document.getElementById('current-chat-title').textContent = allChats[0].title;
      } else {
        createNewChat();
      }
    }

    // === MOBILE SIDEBAR FUNCTIONS ===
    function openSidebar() {
      document.querySelector('.sidebar').classList.add('active');
      document.getElementById('sidebar-overlay').classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
      document.querySelector('.sidebar').classList.remove('active');
      document.getElementById('sidebar-overlay').classList.remove('active');
      document.body.style.overflow = 'hidden';
    }

    // === RENDER FUNCTIONS ===
    function renderHistory() {
      const list = document.getElementById('history-list');
      list.innerHTML = '';
      
      allChats.forEach(chat => {
        const el = document.createElement('div');
        el.className = `sidebar-item p-3 rounded-xl cursor-pointer text-sm transition-all ${
          chat.id === currentChatId ? 'active' : ''
        }`;
        
        el.innerHTML = `
          <div class="font-semibold truncate text-gray-100">${chat.title}</div>
          <div class="text-xs text-gray-400 mt-1 flex items-center gap-2">
            <i class="fas fa-comments"></i>
            <span>${chat.messages.length} pesan</span>
          </div>
        `;
        
        el.onclick = () => {
          currentChatId = chat.id;
          saveChats();
          renderHistory();
          renderChat();
          document.getElementById('current-chat-title').textContent = chat.title;
          closeSidebar();
        };
        
        list.appendChild(el);
      });
    }

    function renderChat() {
      const chat = getCurrentChat();
      const chatBox = document.getElementById('chat');
      chatBox.innerHTML = '';

      if (!chat || chat.messages.length === 0) {
        chatBox.innerHTML = `
          <div class="welcome-screen">
            <div class="welcome-content">
              <div class="w-24 h-24 mx-auto mb-6 animated-gradient rounded-3xl flex items-center justify-center shadow-2xl floating">
                <i class="fas fa-rocket text-white text-4xl"></i>
              </div>
              <h2 class="text-3xl font-black text-gray-900 mb-3 bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                Selamat Datang di ReAi
              </h2>
              <p class="text-gray-600 mb-8 text-lg">AI Assistant yang siap membantu development Anda dengan cepat dan akurat</p>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4 welcome-grid">
                <div class="welcome-card rounded-2xl p-5 cursor-pointer">
                  <div class="text-3xl mb-3">🚀</div>
                  <div class="font-bold text-gray-800 mb-1">Landing Page</div>
                  <div class="text-xs text-gray-500">Buat landing page modern</div>
                </div>
                <div class="welcome-card rounded-2xl p-5 cursor-pointer">
                  <div class="text-3xl mb-3">🎨</div>
                  <div class="font-bold text-gray-800 mb-1">UI Components</div>
                  <div class="text-xs text-gray-500">Komponen UI responsive</div>
                </div>
                <div class="welcome-card rounded-2xl p-5 cursor-pointer">
                  <div class="text-3xl mb-3">⚡</div>
                  <div class="font-bold text-gray-800 mb-1">Quick Code</div>
                  <div class="text-xs text-gray-500">Code snippet cepat</div>
                </div>
              </div>
            </div>
          </div>
        `;
        return;
      }

      chat.messages.forEach((msg) => {
        const div = document.createElement('div');
        div.classList.add('message', 'flex', 'gap-4', 'max-w-5xl', 'mx-auto');
        
        if (msg.role === 'user') {
          div.innerHTML = `
            <div class="ml-auto flex gap-4 max-w-3xl">
              <div class="user-message text-white px-6 py-4 rounded-3xl rounded-tr-md">
                <div class="text-sm font-medium leading-relaxed">${escapeHtml(msg.content)}</div>
              </div>
              <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                <i class="fas fa-user text-white"></i>
              </div>
            </div>
          `;
        } else {
          div.innerHTML = `
            <div class="flex gap-4 w-full">
              <div class="w-12 h-12 animated-gradient rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                <i class="fas fa-robot text-white"></i>
              </div>
              <div class="ai-message px-6 py-5 rounded-3xl rounded-tl-md flex-1">
                ${formatAIResponse(msg.content)}
              </div>
            </div>
          `;
        }
        
        chatBox.appendChild(div);
      });
      
      chatBox.scrollTo({ top: chatBox.scrollHeight, behavior: 'smooth' });
      attachCodeBlockListeners();
    }

    // === SEND MESSAGE ===
    async function sendMessage(e) {
      e.preventDefault();
      const input = document.getElementById('message-input');
      const text = input.value.trim();
      if (!text) return;

      const chat = getCurrentChat();
      if (!chat) return;

      chat.messages.push({ role: 'user', content: text });
      if (chat.title === 'Percakapan Baru') {
        chat.title = text.length > 40 ? text.substring(0, 40) + '...' : text;
        document.getElementById('current-chat-title').textContent = chat.title;
      }
      saveChats();
      renderChat();
      renderHistory();

      input.value = '';
      const sendBtn = document.getElementById('send-btn');
      sendBtn.disabled = true;
      sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

      // Add typing indicator
      const chatBox = document.getElementById('chat');
      const typingDiv = document.createElement('div');
      typingDiv.classList.add('message', 'flex', 'gap-4', 'max-w-5xl', 'mx-auto');
      typingDiv.id = 'typing-indicator';
      typingDiv.innerHTML = `
        <div class="flex gap-4 w-full">
          <div class="w-12 h-12 animated-gradient rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
            <i class="fas fa-robot text-white"></i>
          </div>
          <div class="ai-message px-6 py-5 rounded-3xl rounded-tl-md">
            <div class="typing-indicator">
              <div class="typing-dot"></div>
              <div class="typing-dot"></div>
              <div class="typing-dot"></div>
            </div>
          </div>
        </div>
      `;
      chatBox.appendChild(typingDiv);
      chatBox.scrollTo({ top: chatBox.scrollHeight, behavior: 'smooth' });

      try {
        // === BATAS 1024 BARIS ===
        const fullHistory = [...chat.messages];
        const userMessage = { role: 'user', content: text };
        let totalLines = text.split('\n').length;
        const limitedHistory = [];

        // Tambahkan dari pesan terbaru ke terlama hingga batas 1024 baris
        for (let i = fullHistory.length - 1; i >= 0; i--) {
          const msgLines = fullHistory[i].content.split('\n').length;
          if (totalLines + msgLines > 1024) break;
          totalLines += msgLines;
          limitedHistory.unshift(fullHistory[i]);
        }

        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            message: text,
            model: document.getElementById('model-select').value,
            history: limitedHistory // hanya kirim riwayat yang sudah dibatasi
          })
        });

        if (!res.ok) throw new Error('Network error');
        const data = await res.json();
        if (data.error) throw new Error(data.error);

        // Remove typing indicator
        typingDiv.remove();

        const aiResponse = data.reply;
        chat.messages.push({ role: 'assistant', content: aiResponse });
        saveChats();

        renderChat();
        renderHistory();

      } catch (err) {
        typingDiv.remove();
        chat.messages.push({ 
          role: 'assistant', 
          content: '❌ Maaf, terjadi kesalahan: ' + (err.message || 'Gagal terhubung ke server') 
        });
        saveChats();
        renderChat();
      } finally {
        sendBtn.disabled = false;
        sendBtn.innerHTML = '<i class="fas fa-paper-plane text-lg"></i>';
        input.focus();
      }
    }

    // === INITIALIZATION ===
    document.getElementById('new-chat-btn').addEventListener('click', createNewChat);
    document.getElementById('delete-chat-btn').addEventListener('click', deleteCurrentChat);
    document.getElementById('chat-form').addEventListener('submit', sendMessage);
    document.getElementById('message-input').addEventListener('keydown', (e) => {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage(e);
      }
    });

    // Mobile sidebar controls
    document.getElementById('mobile-menu-btn').addEventListener('click', openSidebar);
    document.getElementById('mobile-close-btn').addEventListener('click', closeSidebar);
    document.getElementById('sidebar-overlay').addEventListener('click', closeSidebar);

    // Initialize app
    if (!currentChatId || !allChats.find(c => c.id === currentChatId)) {
      createNewChat();
    } else {
      renderHistory();
      renderChat();
      const currentChat = getCurrentChat();
      if (currentChat) {
        document.getElementById('current-chat-title').textContent = currentChat.title;
      }
    }

    // Handle window resize
    window.addEventListener('resize', function() {
      if (window.innerWidth <= 768) {
        closeSidebar();
      }
    });
  </script>
</body>
</html>