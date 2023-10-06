// Hashing the password
import bcrypt from 'bcryptjs';
const { genSaltSync, hashSync, compareSync } = bcrypt;


// Function to hash the password
function hashPassword(password) {
  const salt = genSaltSync(10);
  const hash = hashSync(password, salt);
  return hash;
}

// Function to verify the password
function verifyPassword(password, hashedPassword) {
  return compareSync(password, hashedPassword);
}

// Example usage
const password = 'myPassword123';

// Hash the password
const hashedPassword = hashPassword(password);
console.log('Hashed Password:', hashedPassword);

// Verify the password
const isPasswordValid = verifyPassword(password, hashedPassword);
console.log('Password is Valid:', isPasswordValid);
