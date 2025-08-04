document.addEventListener('DOMContentLoaded', () => {
  const questions = document.querySelectorAll('.question');

  questions.forEach(question => {
    question.addEventListener('click', () => {
      const answer = question.querySelector('.answer');

      if (!answer) return;

      const isOpen = answer.classList.contains('show');

      // Close all answers (optional for accordion behavior)
      document.querySelectorAll('.answer').forEach(a => {
        a.classList.remove('show');
        a.style.maxHeight = null;
        a.style.opacity = 0;
      });

      // Toggle current one
      if (!isOpen) {
        answer.classList.add('show');
        answer.style.maxHeight = answer.scrollHeight + 'px';
        answer.style.opacity = 1;
      }
    });
  });
});
