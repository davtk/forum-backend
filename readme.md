This project was created as demonstration of my current skills as a fullstack developer 07/2022.

# Okay, what is that?

Simple discussion/forum system.

What it can do? Hmm. Basically not too much. You can create new thread and comment on that.
The thing is that there is pretty complex backend, which is most likely the reason why you are here.

# Technologies?

Application has separated frontend (Vue.js) and backend (PHP).

- **Frontend here: https://github.com/davtk/forum-frontend**
- This repository is about backend.


So the technologies:

- **hexagonal architecture** - core depends only on abstraction,
- **domain driven design** - at least I tried; I'm still learning this so there may be some mistakes maybe,
- **Nette framework** as part of Infrastructure layer - providing DI container and Presenters as entrypoints (API endpoints),
- **composer** provides autoloading,
- **phpunit** for unit testing,
- **php_codesniffer** with PSR 12 coding standard,
- **zircote/swagger-php** for generating OpenAPI schema,
- **PDO** for persistence, with very simple custom mapper (I am familiar with Doctrine, but it could be overkill for this.. actually, thanks to Hexagonal architecture, it is possible to additionally implement Doctrine as persistence layer without any changes in Domain) 

# How it works

1. **src/Davtk/Forum/Domain** contains business logic of the application,
2. **src/Davtk/Forum/Application** gives you use cases what can you do with the application,
3. **src/Davtk/Forum/Infrastructure** contains adapters - both driving & driven side

In current scenario, the driving side is REST API implemented with Nette Presenters (/src/Davtk/Forum/Infrastructure/Nette).

# Online demo?

// TODO: Coming soon

# Can I run it locally?

Sure thing. // TODO: I will tell you how.

# You like it?

### Great! I'm available to work. Let's connect: https://www.linkedin.com/in/daniel-vitek/

You don't? Great! I would really appreciate your feedback: https://github.com/davtk/forum-backend/issues

