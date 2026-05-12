function initMobileNav() {
  const toggle = document.querySelector(".nav-toggle");
  const menu = document.querySelector(".nav-menu");

  if (!toggle || !menu) {
    return;
  }

  function setOpen(isOpen) {
    toggle.classList.toggle("is-open", isOpen);
    menu.classList.toggle("is-open", isOpen);
    toggle.setAttribute("aria-expanded", String(isOpen));
    document.body.classList.toggle("no-scroll", isOpen);
  }

  toggle.addEventListener("click", () => {
    setOpen(!menu.classList.contains("is-open"));
  });

  menu.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", () => setOpen(false));
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      setOpen(false);
    }
  });
}

function initAnswerCards(scope = document) {
  scope.querySelectorAll(".option-label, .option").forEach((option) => {
    const input = option.querySelector('input[type="radio"]');

    if (!input) {
      return;
    }

    input.addEventListener("change", () => {
      const group = option.closest(".options, .options-wrapper");

      if (group) {
        group.querySelectorAll(".option-label, .option").forEach((item) => {
          item.classList.remove("is-selected");
        });
      }

      option.classList.add("is-selected");
    });

    if (input.checked) {
      option.classList.add("is-selected");
    }
  });
}

function initQuizForm() {
  const form = document.querySelector("[data-quiz-form]");

  if (!form) {
    return;
  }

  const questionBlocks = Array.from(form.querySelectorAll(".question-block"));
  const total = questionBlocks.length;
  const progressBar = form.querySelector("#progressBar");
  const progressText = form.querySelector("#progressText");
  const finishBtn = form.querySelector("#finishBtn");
  let current = 0;

  function answeredCount() {
    return questionBlocks.reduce((count, block) => {
      const hidden = block.querySelector('input[type="hidden"][name^="question_"]');
      return count + (hidden && hidden.value ? 1 : 0);
    }, 0);
  }

  function updateProgress() {
    const answered = answeredCount();
    const percentage = total ? Math.round((answered / total) * 100) : 0;

    if (progressBar) {
      progressBar.style.width = `${percentage}%`;
    }

    if (progressText) {
      progressText.textContent = `${answered} / ${total}`;
    }

    if (finishBtn) {
      finishBtn.hidden = answered !== total;
    }
  }

  function showQuestion(index) {
    questionBlocks.forEach((block, blockIndex) => {
      block.classList.toggle("is-active", blockIndex === index);
    });
    current = index;
    updateProgress();
  }

  function findNextUnanswered(startIndex) {
    for (let index = startIndex + 1; index < total; index += 1) {
      const hidden = questionBlocks[index].querySelector('input[type="hidden"][name^="question_"]');
      if (hidden && !hidden.value) {
        return index;
      }
    }

    for (let index = 0; index < startIndex; index += 1) {
      const hidden = questionBlocks[index].querySelector('input[type="hidden"][name^="question_"]');
      if (hidden && !hidden.value) {
        return index;
      }
    }

    return null;
  }

  questionBlocks.forEach((block, index) => {
    const submitButton = block.querySelector(".submit-answer");
    const hidden = block.querySelector('input[type="hidden"][name^="question_"]');

    if (!submitButton || !hidden) {
      return;
    }

    submitButton.addEventListener("click", () => {
      const checked = block.querySelector('input[type="radio"]:checked');

      if (!checked) {
        showToast("Please select an answer before submitting.", "error");
        return;
      }

      hidden.value = checked.value;
      updateProgress();

      const nextIndex = findNextUnanswered(index);
      if (nextIndex !== null) {
        showQuestion(nextIndex);
      }
    });
  });

  form.addEventListener("keydown", (event) => {
    if (event.key === "Enter" && event.target.matches('input[type="radio"]')) {
      event.preventDefault();
      const activeBlock = questionBlocks[current];
      const submitButton = activeBlock && activeBlock.querySelector(".submit-answer");
      if (submitButton) {
        submitButton.click();
      }
    }
  });

  showQuestion(0);
}

function animateScore() {
  const scoreText = document.querySelector(".score-percentage");
  const scoreCircle = document.querySelector(".score-circle");

  if (!scoreText) {
    return;
  }

  const finalScore = parseFloat(scoreText.textContent) || 0;
  const duration = 900;
  const start = performance.now();

  function tick(now) {
    const progress = Math.min((now - start) / duration, 1);
    const current = Math.round(finalScore * progress);

    scoreText.textContent = `${current}%`;

    if (scoreCircle) {
      scoreCircle.style.setProperty("--score", current);
    }

    if (progress < 1) {
      requestAnimationFrame(tick);
    } else {
      scoreText.textContent = `${finalScore}%`;
      if (scoreCircle) {
        scoreCircle.style.setProperty("--score", finalScore);
      }
    }
  }

  requestAnimationFrame(tick);
}

function showToast(message, type = "info", duration = 3200) {
  const toast = document.createElement("div");
  toast.className = `toast ${type === "error" ? "error-message" : "success-message"}`;
  toast.setAttribute("role", "status");
  toast.setAttribute("aria-live", "polite");
  toast.textContent = message;
  document.body.appendChild(toast);

  window.setTimeout(() => {
    toast.remove();
  }, duration);
}

document.addEventListener("DOMContentLoaded", () => {
  initMobileNav();
  initAnswerCards();
  initQuizForm();
  animateScore();
});
