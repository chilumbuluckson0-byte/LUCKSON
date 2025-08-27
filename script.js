// ======= AUTHENTICATION =======
function isLoggedIn() {
  return localStorage.getItem("loggedInUser") !== null;
}

function getLoggedInUser() {
  return localStorage.getItem("loggedInUser");
}

function renderAuthLinks() {
  const loginLink = document.getElementById("loginLink");
  const signupLink = document.getElementById("signupLink");
  const logoutLink = document.getElementById("logoutLink");

  if (loginLink && signupLink && logoutLink) {
    if (isLoggedIn()) {
      loginLink.style.display = "none";
      signupLink.style.display = "none";
      logoutLink.style.display = "inline";
    } else {
      loginLink.style.display = "inline";
      signupLink.style.display = "inline";
      logoutLink.style.display = "none";
    }
  }
}

function logout() {
  localStorage.removeItem("loggedInUser");
  window.location.href = "login.html";
}

// ======= SIGNUP =======
function signup(username, password) {
  let users = JSON.parse(localStorage.getItem("users")) || [];
  if (users.find(u => u.username === username)) {
    alert("Username already exists!");
    return false;
  }
  users.push({ username, password });
  localStorage.setItem("users", JSON.stringify(users));
  localStorage.setItem("loggedInUser", username);
  return true;
}

// ======= LOGIN =======
function login(username, password) {
  let users = JSON.parse(localStorage.getItem("users")) || [];
  const user = users.find(u => u.username === username && u.password === password);
  if (user) {
    localStorage.setItem("loggedInUser", username);
    return true;
  }
  return false;
}

// ======= BOOKING =======
function bookCar(carId) {
  if (!isLoggedIn()) {
    alert("Please log in to book a car.");
    window.location.href = "login.html";
    return;
  }
  let bookings = JSON.parse(localStorage.getItem("bookings")) || [];
  bookings.push({ user: getLoggedInUser(), carId: carId, date: new Date().toISOString() });
  localStorage.setItem("bookings", JSON.stringify(bookings));
  alert("Car booked successfully!");
}

// ======= LOAD CARS FROM JSON =======
async function loadCars(containerId) {
  try {
    const res = await fetch("cars.json");
    const cars = await res.json();
    const container = document.getElementById(containerId);

    if (container) {
      container.innerHTML = "";
      cars.forEach(car => {
        const card = document.createElement("div");
        card.classList.add("car-card");
        card.innerHTML = `
          <img src="${car.image}" alt="${car.name}">
          <h3>${car.name}</h3>
          <p>${car.price}/day</p>
          <button onclick="bookCar(${car.id})">Book Now</button>
          <a href="car-details.html?id=${car.id}" class="details-btn">View Details</a>
        `;
        container.appendChild(card);
      });
    }
  } catch (error) {
    console.error("Error loading cars:", error);
  }
}

// ======= LOAD DASHBOARD BOOKINGS =======
async function loadDashboard() {
  try {
    const res = await fetch("cars.json");
    const cars = await res.json();
    const bookings = JSON.parse(localStorage.getItem("bookings")) || [];
    const dashboardContainer = document.getElementById("dashboardContainer");

    if (dashboardContainer) {
      const userBookings = bookings.filter(b => b.user === getLoggedInUser());
      dashboardContainer.innerHTML = "";
      userBookings.forEach(b => {
        const car = cars.find(c => c.id === b.carId);
        if (car) {
          const card = document.createElement("div");
          card.classList.add("car-card");
          card.innerHTML = `
            <img src="${car.image}" alt="${car.name}">
            <h3>${car.name}</h3>
            <p>Booked on: ${new Date(b.date).toLocaleDateString()}</p>
          `;
          dashboardContainer.appendChild(card);
        }
      });
    }
  } catch (error) {
    console.error("Error loading dashboard:", error);
  }
}

// ======= ON PAGE LOAD =======
document.addEventListener("DOMContentLoaded", () => {
  renderAuthLinks();

  // Signup page
  const signupForm = document.getElementById("signupForm");
  if (signupForm) {
    signupForm.addEventListener("submit", e => {
      e.preventDefault();
      const username = document.getElementById("signupUsername").value;
      const password = document.getElementById("signupPassword").value;
      if (signup(username, password)) {
        window.location.href = "index.html";
      }
    });
  }

  // Login page
  const loginForm = document.getElementById("loginForm");
  if (loginForm) {
    loginForm.addEventListener("submit", e => {
      e.preventDefault();
      const username = document.getElementById("loginUsername").value;
      const password = document.getElementById("loginPassword").value;
      if (login(username, password)) {
        window.location.href = "index.html";
      } else {
        alert("Invalid username or password");
      }
    });
  }
});
