# Autor
Este proyecto fue desarrollado por Alex Caicedo Ramos. Puedes contactarlo a través de su correo electrónico: chevyagcr@gmail.com.

# Refactorización de Aplicación Laravel: SOLID y Patrones de Diseño

Este proyecto demuestra múltiples técnicas de refactorización en una aplicación Laravel, aplicando principios SOLID y patrones de diseño para mejorar la calidad del código.

## 📌 Refactorizaciones Implementadas

1. **Principios SOLID en módulo de citas**
   - SRP (Principio de Responsabilidad Única)
   - DIP (Principio de Inversión de Dependencias)
   
2. **Patrones de Diseño en módulo de chat**
   - Factory Pattern (Patrón Fábrica)
   - Command Pattern (Patrón Comando)

---

## 1. Refactorización de Módulo de Citas (SOLID)

### 1.1 Principio de Responsabilidad Única (SRP)

#### Implementación:
- **Form Request para validaciones**  
  `StoreAppointmentRequest` maneja reglas de validación
# Refactorización de Aplicación Laravel: SOLID y Patrones de Diseño

## Autor
Este proyecto fue desarrollado por Alex Caicedo Ramos. Puedes contactarlo a través de su correo electrónico: chevyagcr@gmail.com.

## 📌 Refactorizaciones Implementadas

1. **Principios SOLID en múltiples módulos**
   - SRP (Módulo de Citas)
   - DIP (Módulo de Citas)
   - ISP (Módulo de Dashboard)

2. **Patrones de Diseño**
   - Factory y Command (Módulo de Chat)
   - Service Pattern (Módulo de Perfiles)



## 1. Aplicación de Principios SOLID

### 1.1 Principio de Responsabilidad Única (SRP) - Módulo de Citas

#### Implementación:
- **Form Request para validaciones**  
  `StoreAppointmentRequest` maneja reglas de validación

  ```php
  // app/Http/Requests/StoreAppointmentRequest.php
  public function rules() {
      return [
          'partner_id' => ['required', 'exists:users,id'],
          'date' => ['required', 'date']
      ];
  }
  ```

- **Servicio para lógica de negocio**  
  `AppointmentService` centraliza operaciones

  ```php
  // app/Services/AppointmentService.php
  public function createAppointment($validatedData) {
      return $this->appointmentRepository->create([
          'user_id' => Auth::id(),
          'partner_id' => $validatedData['partner_id'],
          'date' => $validatedData['date']
      ]);
  }
  ```

### 1.2 Principio de Inversión de Dependencias (DIP)

#### Implementación:
- **Capa de Repositorio Abstracta**
  ```php
  // app/Repositories/AppointmentRepositoryInterface.php
  interface AppointmentRepositoryInterface {
      public function create(array $data): Appointment;
      public function delete(Appointment $appointment): void;
  }
  ```

- **Implementación Concreta (Eloquent)**
  ```php
  // app/Repositories/EloquentAppointmentRepository.php
  class EloquentAppointmentRepository implements AppointmentRepositoryInterface {
      public function create(array $data): Appointment {
          return Appointment::create($data);
      }
  }
  ```

### 1.3 Interface Segregation Principle (ISP) - Dashboard

#### Implementación:
- **Servicios Especializados**
  ```php
  app/
  └── Services/
      ├── UserFilterService.php       # Filtrado de usuarios
      ├── AgeCalculationService.php   # Cálculo de edades
      └── AppointmentService.php      # Gestión de citas
  ```

- **Controlador Refactorizado:**
  ```php
  class DashboardController extends Controller
  {
      public function __construct(
          protected UserFilterService $userFilterService,
          protected AgeCalculationService $ageCalculationService,
          protected AppointmentService $appointmentService
      ) {}

      public function index(Request $request)
      {
          $users = $this->userFilterService->filter($request);
          foreach ($users as $user) {
              $user->age = $this->ageCalculationService->calculate($user);
          }
          $appointments = $this->appointmentService->getAppointments();

          return view('dashboard', compact('users', 'appointments'));
      }
  }
  ```

---

## 2. Refactorización de Módulo de Chat (Patrones de Diseño)

### 2.1 Patrón Fábrica (Factory Pattern)

#### Implementación:
- **Interfaz de Fábrica**
  ```php
  // app/Factories/ChatFactoryInterface.php
  interface ChatFactoryInterface {
      public function createChat($userId): Chat;
  }
  ```

- **Fábrica para Chats de 2 Usuarios**
  ```php
  // app/Factories/TwoUserChatFactory.php
  class TwoUserChatFactory implements ChatFactoryInterface {
      public function createChat($userId): Chat {
          // Lógica para crear/obtener chat
      }
  }
  ```

### 2.2 Patrón Comando (Command Pattern)

#### Implementación:
- **Clase Comando para Envío de Mensajes**
  ```php
  // app/Commands/SendMessageCommand.php
  class SendMessageCommand {
      public function execute() {
          return Message::create([
              'chat_id' => $this->chatId,
              'user_id' => Auth::id(),
              'content' => $this->messageContent
          ]);
      }
  }
  ```

- **Uso en Controlador**
  ```php
  // app/Http/Controllers/ChatController.php
  public function sendMessage(Request $request, $chatId) {
      $command = new SendMessageCommand($chatId, $request->message);
      $command->execute();
      return back();
  }
  ```

---

## 3. Implementación del Patrón de Diseño **Service** en el Proyecto

### Introducción

El patrón **Service** se utiliza para separar la lógica de negocio del controlador, promoviendo una arquitectura más limpia y mantenible.

#### Objetivos:
- **Separación de responsabilidades:** El controlador maneja las peticiones y respuestas, mientras que la lógica de negocio se delega al servicio.
- **Reusabilidad:** La lógica de negocio es reutilizable en otras partes del sistema sin duplicación.
- **Mantenibilidad:** El código es más fácil de mantener al centralizar la lógica de negocio.

### ¿Cómo Implementamos el Patrón **Service**?

#### Paso 1: Crear el Servicio

La clase `ProfileService` maneja toda la lógica relacionada con los perfiles de usuario.

```php
// app/Services/ProfileService.php
namespace App\Services;

use App\Models\Profile;

class ProfileService
{
    public function createProfile(array $data, $userId)
    {
        $profile = new Profile($data);
        $profile->user_id = $userId;
        $profile->save();
        return $profile;
    }

    public function updateProfile(array $data, $user)
    {
        $user->profile->update($data);
        return $user->profile;
    }

    public function deleteProfile($user)
    {
        $user->profile()->delete();
        $user->delete();
    }
}
```

#### Paso 2: Modificar el Controlador

Inyectamos `ProfileService` en `ProfileController` para delegar la lógica de negocio.

```php
// app/Http/Controllers/ProfileController.php
namespace App\Http\Controllers;

use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([...]); // Validar los datos
        $this->profileService->createProfile($validated, $request->user()->id); 
        return redirect()->route('profile.show')->with('status', 'Profile created successfully!');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([...]); // Validar los datos
        $this->profileService->updateProfile($validated, $request->user());
        return redirect()->route('profile.show')->with('status', 'Profile updated successfully!');
    }

    public function destroy(Request $request)
    {
        $this->profileService->deleteProfile($request->user());
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
```

#### Paso 3: Registrar el Servicio

El servicio se registra automáticamente a través de la **Dependency Injection** de Laravel.

#### Paso 4: Probar el Servicio

La lógica del servicio ahora está centralizada y es fácilmente testeable.

---

## 🗂 Estructura del Proyecto Unificada
```
app/
├── Commands/
│   └── SendMessageCommand.php
├── Factories/
│   ├── ChatFactoryInterface.php
│   └── TwoUserChatFactory.php
├── Http/
│   ├── Controllers/
│   │   ├── AppointmentController.php
│   │   └── ProfileController.php
│   │   └── ChatController.php
│   └── Requests/
│       └── StoreAppointmentRequest.php
├── Models/
│   ├── Appointment.php
│   ├── Chat.php
│   └── Profile.php
├── Repositories/
│   ├── AppointmentRepositoryInterface.php
│   └── EloquentAppointmentRepository.php
├── Services/
│   ├── ProfileService.php
│   ├── UserFilterService.php
│   ├── AgeCalculationService.php
│   └── AppointmentService.php
└── Providers/
    └── AppServiceProvider.php
```

---

## ✅ Beneficios Obtenidos

**Módulo de Citas:**
- Controladores delgados (<100 líneas)
- Fácil cambio de ORM sin modificar servicios
- Validaciones reutilizables

**Módulo de Chat:**
- Creación flexible de diferentes tipos de chat
- Operaciones complejas encapsuladas en comandos
- Código más testeable

**Módulo de Perfiles:**
- Lógica de negocio centralizada en servicios
- Controladores delgados y enfocadas en las peticiones
- Fácilmente extensible y reutilizable

---

## 🚀 Posibles Próximos Pasos

1. Implementar **Observer Pattern** para notificaciones
2. Crear **Decorators** para enriquecer mensajes
3. Desarrollar **Strategy Pattern** para diferentes tipos de citas
4. Implementar **CQRS** para operaciones complejas

---

## 📚 Conclusión

Esta refactorización demuestra cómo:
1. **SOLID** mejora el diseño, facilitando el mantenimiento y la escalabilidad.
2. Los **Patrones de Diseño** optimizan la organización del código, haciéndolo más flexible, reutilizable y testeable.
```
  ```php
  // app/Http/Requests/StoreAppointmentRequest.php
  public function rules() {
      return [
          'partner_id' => ['required', 'exists:users,id'],
          'date' => ['required', 'date']
      ];
  }


- **Servicio para lógica de negocio**  
  `AppointmentService` centraliza operaciones

  ```php
  // app/Services/AppointmentService.php
  public function createAppointment($validatedData) {
      return $this->appointmentRepository->create([
          'user_id' => Auth::id(),
          'partner_id' => $validatedData['partner_id'],
          'date' => $validatedData['date']
      ]);
  }
  ```

### 1.2 Principio de Inversión de Dependencias (DIP)

#### Implementación:
- **Capa de Repositorio Abstracta**
  ```php
  // app/Repositories/AppointmentRepositoryInterface.php
  interface AppointmentRepositoryInterface {
      public function create(array $data): Appointment;
      public function delete(Appointment $appointment): void;
  }
  ```

- **Implementación Concreta (Eloquent)**
  ```php
  // app/Repositories/EloquentAppointmentRepository.php
  class EloquentAppointmentRepository implements AppointmentRepositoryInterface {
      public function create(array $data): Appointment {
          return Appointment::create($data);
      }
  }
  ```

---

## 2. Refactorización de Módulo de Chat (Patrones de Diseño)

### 2.1 Patrón Fábrica (Factory Pattern)

#### Implementación:
- **Interfaz de Fábrica**
  ```php
  // app/Factories/ChatFactoryInterface.php
  interface ChatFactoryInterface {
      public function createChat($userId): Chat;
  }
  ```

- **Fábrica para Chats de 2 Usuarios**
  ```php
  // app/Factories/TwoUserChatFactory.php
  class TwoUserChatFactory implements ChatFactoryInterface {
      public function createChat($userId): Chat {
          // Lógica para crear/obtener chat
      }
  }
  ```

### 2.2 Patrón Comando (Command Pattern)

#### Implementación:
- **Clase Comando para Envío de Mensajes**
  ```php
  // app/Commands/SendMessageCommand.php
  class SendMessageCommand {
      public function execute() {
          return Message::create([
              'chat_id' => $this->chatId,
              'user_id' => Auth::id(),
              'content' => $this->messageContent
          ]);
      }
  }
  ```

- **Uso en Controlador**
  ```php
  // app/Http/Controllers/ChatController.php
  public function sendMessage(Request $request, $chatId) {
      $command = new SendMessageCommand($chatId, $request->message);
      $command->execute();
      return back();
  }
  ```

---

## 🗂 Estructura del Proyecto Unificada
```
app/
├── Commands/
│   └── SendMessageCommand.php
├── Factories/
│   ├── ChatFactoryInterface.php
│   └── TwoUserChatFactory.php
├── Http/
│   ├── Controllers/
│   │   ├── AppointmentController.php
│   │   └── ChatController.php
│   └── Requests/
│       └── StoreAppointmentRequest.php
├── Models/
│   ├── Appointment.php
│   ├── Chat.php
│   └── Message.php
├── Repositories/
│   ├── AppointmentRepositoryInterface.php
│   └── EloquentAppointmentRepository.php
├── Services/
│   └── AppointmentService.php
└── Providers/
    └── AppServiceProvider.php
```

---

## ✅ Beneficios Obtenidos

**Módulo de Citas:**
- Controladores delgados (<100 líneas)
- Fácil cambio de ORM sin modificar servicios
- Validaciones reutilizables

**Módulo de Chat:**
- Creación flexible de diferentes tipos de chat
- Operaciones complejas encapsuladas en comandos
- Código más testeable

---

## 🚀 Posibles Proximos Pasos

1. Implementar **Observer Pattern** para notificaciones
2. Crear **Decorators** para enriquecer mensajes
3. Desarrollar **Strategy Pattern** para diferentes tipos de citas
4. Implementar **CQRS** para operaciones complejas

---

## 📚 Conclusión

Esta refactorización demuestra cómo:
1. **SOLID** mejora el diseño de componentes críticos
2. Los **Patrones de Diseño** resuelven problemas comunes
3. La **separación de responsabilidades** facilita el mantenimiento

El código resultante es más flexible, escalable y preparado para nuevos requerimientos.
