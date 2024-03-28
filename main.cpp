#include <httplib.h>

int main() {
    httplib::Server svr;

    svr.Get("/hello", [](const httplib::Request& req, httplib::Response& res) {
        res.set_content("Hello, World!", "text/plain");
    });

    svr.listen("localhost", 8080);

    return 0;
}
